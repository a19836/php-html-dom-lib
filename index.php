<?php
/*
 * Copyright (c) 2025 Bloxtor (http://bloxtor.com) and Joao Pinto (http://jplpinto.com)
 * 
 * Multi-licensed: BSD 3-Clause | Apache 2.0 | GNU LGPL v3 | HLNC License (http://bloxtor.com/LICENSE_HLNC.md)
 * Choose one license that best fits your needs.
 *
 * Original PHP Html Dom Lib Repo: https://github.com/a19836/phphtmldomlib/
 * Original Bloxtor Repo: https://github.com/a19836/bloxtor
 *
 * YOU ARE NOT AUTHORIZED TO MODIFY OR REMOVE ANY PART OF THIS NOTICE!
 */
?>
<style>
h1 {margin-bottom:0; text-align:center;}
h5 {font-size:1em; margin:40px 0 10px; font-weight:bold;}
p {margin:0 0 20px; text-align:center;}

.note {text-align:center;}
.note span {text-align:center; margin:0 20px 20px; padding:10px; color:#aaa; border:1px solid #ccc; background:#eee; display:inline-block; border-radius:3px;}
.note li {margin-bottom:5px;}

.code {display:block; margin:10px 0; padding:0; background:#eee; border:1px solid #ccc; border-radius:3px; position:relative;}
.code:before {content:"php"; position:absolute; top:5px; left:5px; display:block; font-size:80%; opacity:.5;}
.code textarea {width:100%; height:300px; padding:30px 10px 10px; display:inline-block; background:transparent; border:0; resize:vertical; font-family:monospace;}
.code.short textarea {height:160px;}
</style>
<h1>PHP Html Dom Lib</h1>
<p>Manipulate Dom nodes</p>
<div class="note">
		<span>
		This library parses, inspects, and manipulates HTML content using a DOM-based approach.<br/>
		It provides a high-level API on top of PHP’s DOM engine, making it easy to read, modify, query, and rewrite HTML documents programmatically.<br/>
		<br/>
		The library can detect whether a given input contains valid HTML and safely handle both raw text and structured HTML/XML content. Once loaded, it exposes the underlying `DOMDocument` while also offering convenient helper methods to simplify common DOM operations.<br/>
		<br/>
		With this library, you can:<br/>
		<ul style="display:inline-block; text-align:left;">
			<li>Detect whether a string contains HTML content</li>
			<li>Access and work directly with the underlying `DOMDocument`</li>
			<li>Traverse and iterate DOM nodes</li>
			<li>Query elements using tag names or CSS selectors</li>
			<li>Read and modify element styles and attributes</li>
			<li>Generate CSS selectors for DOM nodes</li>
			<li>Retrieve and modify inner HTML and outer HTML</li>
			<li>Remove DOM elements safely</li>
			<li>Resize images based on width and height attributes defined in HTML</li>
			<li>Work with inline images (base64), including decoding, extracting metadata, and saving them to files</li>
			<li>Export the modified HTML as encoded or exact (non-encoded) output</li>
		</ul>
		<br/>
		The library supports modern DOM manipulation patterns such as `querySelector` and `querySelectorAll`, enabling familiar and expressive HTML queries similar to those found in frontend JavaScript environments.<br/>
		<br/>
		This library is ideal for content processing, HTML sanitization, email template manipulation, web scraping preparation, WYSIWYG editors, and server-side HTML transformations.
		</span>
</div>

<div>
	<h5>Usage</h5>
	<div class="code">
		<textarea readonly>
include __DIR__ . "/HtmlDomHandler.php";

//init html dom handler
$HtmlDomHandler = new HtmlDomHandler($html, $encoding = "utf-8");

$is_html = $HtmlDomHandler->isHTML(); //note that it could be a sinple text without html/xml tags

if ($is_html) {
	//get Dom engine
	$DOMDocument = $HtmlDomHandler->getDOMDocument();
	
	//get some nodes
	$nodes = $DOMDocument->childNodes;
	$nodes = $DOMDocument->getElementsByTagName("li");
	
	//loop nodes
	if ($nodes) {
		foreach ($nodes as $node) {
			//change style display of node
			$display = $HtmlDomHandler->getElementStyle($node, "display");
			
			if ($display == "none")
				$HtmlDomHandler->setElementStyle($node, "display", "block");
			else {
				//get selector
				$selector = $HtmlDomHandler->getNodeCssSelector($node);
				$selector_parts = explode(" > ", $selector);
				array_pop($selector_parts);
				array_shift($selector_parts);
				$selector = implode(' > ', $selector_parts);
				
				//get inner nodes
				$other_nodes = $HtmlDomHandler->querySelectorAll($selector);
			}
			
			//get inner html of a node
			$inner_html = $HtmlDomHandler->innerHTML($node);
		}
		
		//get outer html of first node
		$outer_html = $HtmlDomHandler->outerHTML( $nodes->item(0) );
	}

	//remove a dom element
	$node = $DOMDocument->getElementById("some_node_id");
	$node->remove();

	//Resize all images according with width and height defined in html
	$HtmlDomHandler->resizeImages();

	//get html after excute changes above
	$encoded_html = $HtmlDomHandler->getHtml(); //get html encoded (note that some elements with src and href attribtues, may have the attributes values encoded)
	$non_encoded_html = $HtmlDomHandler->getHtmlExact(); //get non encoded html
	
	//print modified html
	echo $non_encoded_html;
}
else//print original html input
	echo $html;
		</textarea>
	</div>
</div>

<div>
	<h5>Other methods:</h5>
	<div class="code short">
		<textarea readonly>
$HtmlDomHandler->resizeImages();
$HtmlDomHandler->isInlineImage($img);
$HtmlDomHandler->getInlineImageBase64Data($img);
$HtmlDomHandler->getInlineImageBase64DataDecoded($img);
$HtmlDomHandler->getInlineImageContentType($img);
$HtmlDomHandler->saveInlineImageToFile($img, $file_path);
$HtmlDomHandler->querySelectorAll($css_selector, $element = null);
$HtmlDomHandler->querySelector($css_selector, $element = null);
		</textarea>
	</div>
</div>
