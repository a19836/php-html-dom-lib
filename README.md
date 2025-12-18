# PHP Html Dom Lib

> Original Repos:   
> - PHP Html Dom Lib: https://github.com/a19836/phphtmldomlib/   
> - Bloxtor: https://github.com/a19836/bloxtor/

## Overview

**PHP HTML DOM Lib** is a library designed to parse, inspect, and manipulate HTML content using a DOM-based approach.  
It provides a high-level API on top of PHP’s DOM engine, making it easy to read, modify, query, and rewrite HTML documents programmatically.

The library can detect whether a given input contains valid HTML and safely handle both raw text and structured HTML/XML content. Once loaded, it exposes the underlying `DOMDocument` while also offering convenient helper methods to simplify common DOM operations.

With this library, you can:
- Detect whether a string contains HTML content
- Access and work directly with the underlying `DOMDocument`
- Traverse and iterate DOM nodes
- Query elements using tag names or CSS selectors
- Read and modify element styles and attributes
- Generate CSS selectors for DOM nodes
- Retrieve and modify inner HTML and outer HTML
- Remove DOM elements safely
- Resize images based on width and height attributes defined in HTML
- Work with inline images (base64), including decoding, extracting metadata, and saving them to files
- Export the modified HTML as encoded or exact (non-encoded) output

The library supports modern DOM manipulation patterns such as `querySelector` and `querySelectorAll`, enabling familiar and expressive HTML queries similar to those found in frontend JavaScript environments.

This library is ideal for content processing, HTML sanitization, email template manipulation, web scraping preparation, WYSIWYG editors, and server-side HTML transformations.

To see a working example, open [index.php](index.php) on your server.

---

## Usage

```php
include __DIR__ . "/lib/HtmlDomHandler.php";

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
```

## Other Methods

```php
$HtmlDomHandler->resizeImages();
$HtmlDomHandler->isInlineImage($img);
$HtmlDomHandler->getInlineImageBase64Data($img);
$HtmlDomHandler->getInlineImageBase64DataDecoded($img);
$HtmlDomHandler->getInlineImageContentType($img);
$HtmlDomHandler->saveInlineImageToFile($img, $file_path);
$HtmlDomHandler->querySelectorAll($css_selector, $element = null);
$HtmlDomHandler->querySelector($css_selector, $element = null);
```

