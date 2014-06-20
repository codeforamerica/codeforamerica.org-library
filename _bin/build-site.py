#!/usr/bin/env python
''' Check out this site based on recent successful Travis CI build.

With Travis (https://travis-ci.org) configured on a repository, use this
script within a scheduled cron job to automatically check out the most-recently
passed commit.

Requires a writeable checkout directory and lock file.
Expects piped JSON input from Travis CI, with a list of recent builds:

    https://api.travis-ci.org/docs/#/repos/:owner_name/:name/builds

Sample usage:

    <travis JSON> | build-it.py <checkout dir> <lock file>

Typical usage in a shell script:

    #!/bin/bash -e
    source /etc/profile.d/rvm.sh

    git --work-tree /home/u/cfa --git-dir /home/u/cfa/.git fetch -q
    curl -s https://api.travis-ci.org/repos/codeforamerica/codeforamerica.org/builds \
       | LC_ALL="en_US.UTF-8" /path/to/build-it.py /home/u/cfa /home/u/cfa.lock

The environment variable LC_ALL above is used to handle this Jekyll bug:

    https://github.com/jekyll/jekyll/issues/960#issuecomment-31343130
'''
from contextlib import contextmanager
from subprocess import call, check_call, check_output, PIPE
from fcntl import flock, LOCK_EX, LOCK_UN
from datetime import datetime
from os import chdir
from sys import argv, stdin
from json import load

@contextmanager
def locked_file(path):
    ''' Create a file, lock it, then unlock it. Use as a context manager.
    '''
    try:
        file = open(path, 'a+')
        flock(file, LOCK_EX)
        
        yield file

    finally:
        flock(file, LOCK_UN)

def missing_ref(ref):
    return call(('git', 'cat-file', 'commit', ref), stdout=PIPE) != 0

def read_commit(file):
    file.seek(0)
    return file.read().strip()

def checkout_ref(ref):
    print '    git checkout', ref
    return check_call(('git', 'checkout', '-q', ref), stdout=PIPE)

def write_commit(file, commit):
    file.seek(0)
    file.truncate()
    file.write(commit)

if __name__ == '__main__':

    checkout_dir, lock_path, state_file = argv[1:4]
    
    print '==>', datetime.now(), checkout_dir, '+', lock_path
    
    chdir(checkout_dir)

    for build in load(stdin):
        if build['result'] is None:
            print '   ', 'Skipping %(number)s - returned %(result)s' % build
            continue
        
        if missing_ref(build['commit']):
            print '   ', 'Skipping %(number)s - missing %(commit)s' % build
            continue

        if build['result'] != 0:
            with open(state_file, 'w') as state:
                print >> state, 'Failed Travis build %(number)s' % build
    
            print '   ', 'Skipping %(number)s - errored %(result)s' % build
            continue
        
        with locked_file(lock_path) as lock_file:
            previous_commit = read_commit(lock_file)
            
            if previous_commit == build['commit']:
                print '   ', 'Stopping at %(number)s - already have %(commit)s' % build
                break
        
            print '-->', 'Build %(number)s - %(finished_at)s' % build

            try:
                checkout_ref(build['commit'])
                
                write_commit(lock_file, build['commit'])

            except Exception, e:
                with open(state_file, 'w') as state:
                    print >> state, 'Failed to build %(commit)s,' % build,
                    print >> state, e
    
                print 'ERR', e
            
            else:
                with open(state_file, 'w') as state:
                    print >> state, 'OK'

        break
