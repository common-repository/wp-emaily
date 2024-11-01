<style type="text/css" media="screen">
	/* layouts */
	div.layout {
	}

	div.column {
		float: left;
	}

	/* 1/5 of the width */
	div.fifths div.column {
		width: 180px;
	}

	/* 1/4 of the width */
	div.fourths div.column {
		width: 220px;
	}

	/* 1/3 of the width */
	div.thirds div.column {
		width: 298px;
	}
	div.thirds div.column-2 {
		margin: 0 20px;
	}

	/* first column has 2/3, second has 1/3 of the width */
	div.two-thirds div.column-1 {
		margin-right: 12px; padding-right: 12px;
		width: 615px;
	}
	div.two-thirds div.column-2 {
		margin-left: 12px;
		width: 270px;
	}

	/* 1/2 of the width */
	div.half div.column  {
		width: 450px
	}
	div.half div.column-2 {
		margin-left: 30px;
	}
	
	small {
		display: block;
	}

	/* for safari */
	div.layout  {
		display: block;
	}
	
	div#wp_emaily label {
		display: block;
	}
	
	div#wp_emaily label input {
		padding: 4px;
	}
	
	div#wp_emaily hr {
		display: block;
		margin: 12px 0;
		border: 1px solid #ededed;
	}
	
	div#wp_emaily hr.end {
		margin: 22px 0;
		border: 1px solid #000;
	}
	
	div#wp_emaily .warning {
		color: #f00;
	}
	
	div#wp_emaily ul.float {
		list-style-type: none;
		margin: 0; padding: 0;
	}
	div#wp_emaily ul.float li {
		float: left;
		display: block;
	}
	
	.clearfix:after, .layout:after {
	    content: "."; 
	    display: block;
	    height: 0; 
	    clear: both; 
	    visibility: hidden;
	}

	/* Hides from IE-mac \*/
	* html .clearfix {height: 1%;}
	* html .layout {height: 1%;}
	/* End hide from IE-mac */

</style>