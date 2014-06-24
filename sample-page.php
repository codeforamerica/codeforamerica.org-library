<?php
    
    require_once 'lib.php';
    $context = new Context('data.db');
    $title = 'Sample Page';

?>
<!DOCTYPE html>
<html lang="en-us">
<? include 'includes/head.php' ?>
<body>
<div class="js-container">
<? include 'includes/header.php' ?>
<main role="main">
<div class="layout-semibreve">
    <? include 'includes/header-breadcrumbs.php' ?>
    <!--
    
    Start editing here...
    
    -->
	
    	<h2>Open by Default</h2>
	<h4>A comprehensive playbook to help you get open data started in your city or county.</h4>
<div>	
			<p>When public data is made freely available in open, standardized formats, it can drive transparency, community engagement, and accountability. Governments around the country are building a culture and commitment to openness in City Hall across departments by making government data openly and easily available to citizens — and supporting open data with process and technology.</p>
			<p>In this guide, we’ll explain some of the practical tactics and considerations you’ll need to know to get an open data initiative off the ground in your city or county, drawing upon the experience and expertise of other governments who have successfully done so.</p>
</div>
<hr>
<div class="layout-minor">
	    	
	        <nav role="navigation" class="toc" id="toc">
	        	
	        	<h4>Table of Contents</h4>
	        
		        <ul class="sectlevel1">
		            <li><a href="#intro">Introduction: What is open data, and why bother?</a></li>
		            <li><a href="#groundwork">Laying the Groundwork for Open Data</a></li>
		            <li><a href="#publishing">Opening and Publishing Data</a></li>
		            <li><a href="#sustainability">Planning for Sustainability</a></li>
		            <li><a href="#utility">Making Open Data Useful</a></li>
		            <li><a href="#resources">Further Resources</a></li>
		        </ul>
		        
		 </nav>
</div>
<div class="layout-major">
	<div class="badge-heading badge-gov badge-blue" id="intro">
	<h3>Introduction: What is open data, and why bother?</h3>
	</div>
	<p>Government data is a valuable public resource that, when accessible by every community member, can be a powerful tool to support the goals and values of the community. Cities and counties around the country are making an effort to ensure the data they hold is freely and easily available to the public by embracing and institutionalizing the practice of “open data.”</p>
	<p>What is open data? Basically, open data refers to data (such as documents, databases, records, or transcripts, including those managed by outside vendors) released by a government or organization that is:</p>
	<ul>
		<li>freely available to be used, shared, and reused by anyone for any purpose, commercial or otherwise.</li>
		<li>available in digital, machine-readable formats (such as .csv) so that it can be used in combination with other data and applications.</li>
		<li>available in its entirety — and able to be downloaded “in bulk” and not just manually retrieved record-by-record.</li>
	</ul>
	<p>There are many benefits of opening data. By opening data in machine-readable formats, governments can:</p>
	<ul>
		<li>Build new avenues for civic engagement and participation (technologists can use the data to build or deploy an existing app).</li>
		<li>Create internal efficiencies and save money by creating a centralized place those inside and outside government can easily find the information they need.</li>
		<li>Be a platform for new apps, services, and businesses to be built upon, spurring economic development.</li>
		<li>Increase transparency and trust between government and community. </li>
		<li>Make important and useful community information more accessible to residents. </li>
		<li>Reduce the burden on government staff to respond to repetitive public records requests by making frequently-requested information available to residents in a self-serve format.</li>
	</ul>
	<p>These are just a few of the reasons your government might decide to pursue an open data initiative. In this guide, we’ll explain some of the practical tactics and considerations you’ll need to know to get an open data initiative off the ground in your city or county — drawing upon the experience and expertise of other governments from around the country who have successfully done so.</p>
	<h4>Acknowledgements:</h4>
	<p>Many individuals and organizations contributed their knowledge and expertise to this guide. In particular, we would like to thank: Mark Headd, Jim Craner, Peter Koht, Amy Mok, Dave Guarino, Tim O’Reilly, David Eaves, Laura Meixell, Rebecca Williams, Mark Leech, Tim Welsh, Jenny Park, Tim Moreland, Daniel Hoffman, Millie Crossland, Jack Madans, Mike Migurski, Garrett Jacobs, the Sunlight Foundation, and the Open Knowledge Foundation.</p>
	
</div>
<div class="layout-semibreve">
	<div class="badge-heading badge-gov badge-blue" id="groundwork">
	<h3>Laying the Groundwork for Open Data</h3>
	</div>
	<h4>Define the goals of your open data initiative</h4>
	<ul class="teasers"><li class="layout-crotchet">
        <article class="teaser">
            <header class="teaser-header">
                <a href="/library/item/f455738399e69e62">
                    <h1 class="teaser-title">Civic App Demo: Open 311 Dashboard</h1>
                </a>
            </header>
            <div class="teaser-body">
                
            </div>
            <footer class="teaser-footer">
                <a href="/library/item/f455738399e69e62" class="teaser-masthead">
                    <img class="teaser-image" src="http://i.vimeocdn.com/video/243444779_640.jpg" style="top: -34px; position: relative">
                    <span class="teaser-type teaser-type-article">Video, 2011</span>
                </a>
                <a href="/library/category/Defaulting+to+Open" class="teaser-source">Defaulting to Open</a>
            </footer>
        </article>
        </li></ul><p>In order to be successful, open data initiatives must be clearly aligned with larger strategic goals and objectives. Opening data just for the sake of “doing open data” is a recipe for frustration, confusion, and lack of long-term impact.</p>
	<p>So, before getting started, it's key to define your goals for open data. Being clear about this from the beginning will make it easier to articulate the value and get other stakeholders on board. Ask yourself: Why is open data important for your government? What do you hope to accomplish? How can open data support the existing needs and priorities of your government and leadership?</p>
	<h4>Common goals for open data</h4>
	<p>Depending on a combination of resources, priorities, and values, cities may have any number of goals for an open data initiative. Common goals include:</p>
	<ul>
		<li>Increase interoperability between systems and data-driven applications within City Hall and with other jurisdictions.</li>
		<li>Save staff time and create efficiencies by increasing information sharing between departments.</li>
		<li>Provide citizens information to better understand their government's activities and participate in improving the quality of life and promoting economic development.</li>
		<li>Provide greater awareness of — and availability of — data for data-driven decision-making throughout City Hall.</li>
		<li>Seed the environment for a local civic technology ecosystem.</li>
		<li>Capitalize on applications and services built on open data standards in other cities.</li>
		<li>Increase communication and demonstrate openness to build citizens’ trust in government.</li>
	</ul>
	<h4>Aligning it with organizational goals and priorities</h4>
	<p>Showing how open data can drive progress on high-priority issues can help generate initial buy-in from leadership, establish quick wins, and generate momentum to get a longer-term open data initiative off the ground. When crafting your rationale for open data, you should consider how open data can strategically support high-level policy priorities specific to your local context — such as creating jobs, reducing vacant and abandoned properties, or increasing government transparency. You might want to review recent high-profile speeches from your city’s leadership, such as an annual State of the City address, to identify key issues.</p>
	<p>Be creative and push your thinking about how open data could have an impact in unexpected areas. For example, in Boston, Mayor Menino stated in his 2012 State of the City address that he wanted to the improve school selection process for families. Using open data, the city then <a href="http://beyondtransparency.org/chapters/part-1/open-data-and-open-discource-at-boston-public-schools/">built a simple web interface</a> to help parents easily see what schools their child was eligible for and compare them on a range of dimensions like test scores, after-school programs offered, and travel time from their home.</p>
	<h4>What to expect: How open data has worked for cities of all sizes</h4>
	<p>There’s a way to do open data on any budget. Cities and counties with populations (and budgets) of all sizes have launched successful open data initiatives. The strategy and structure you choose to pursue should be informed by an understanding of your government’s resources, political environment, and priorities. Cost, demands on staff time, technology needs, and team structure can vary widely.</p>
	<p>Other cities have paved the way and can serve as a model for what to expect as you launch your own open data initiative. Here are some examples of how other cities have done it, told by the government staff who made it happen.</p>
			{% include projects/louisville-open-data.html context="project-abstract" base="../.." %}
</div>

    <!--
    
    ...finish editing here.
    
    -->
</div>
<? include 'includes/footer.php' ?>
</main>
</div><!-- /.js-container -->
<? include 'includes/footer-scripts.php' ?>
</body>
</html>
