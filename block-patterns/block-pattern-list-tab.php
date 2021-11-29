<?php

$html = <<<HTML
<!-- wp:list {"className":"list-style-tab emulsion-block-pattern-list-tab"} -->
<ul class="list-style-tab emulsion-block-pattern-list-tab">
	<li>tab 1
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, </li>
		</ul>
	</li>
	<li>tab 2
		<ul>
			<li> Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </li>
		</ul>
	</li>
</ul>
<!-- /wp:list -->
HTML;

$html = str_replace( array(PHP_EOL,"\t"), array('',''), $html );

return $html;
