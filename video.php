
<!-- 
	A minimal setup to get you started. This configuration is the same
	as in our Quick Start documentation:
	
	http://flowplayer.org/player/quick-start.html
--><head>  

	<title>ALAS VIDEO</title>
	
	<!-- 
		include flashembed - which is a general purpose tool for 
		inserting Flash on your page. Following line is required.
	-->
	<script type="text/javascript" src="javascript/flashembed.min.js"></script>
	
	<!-- some minimal styling, can be removed 
	<link rel="stylesheet" type="text/css" href="css/common.css"/>-->

	<script>
	
	 /*
		use flashembed to place flowplayer into HTML element 
		whose id is "example" (below this script tag)
	 */
	 flashembed("example", 
	
		/* 
			first argument supplies standard Flash parameters. See full list:
			http://kb.adobe.com/selfservice/viewContent.do?externalId=tn_12701
		*/
		{
			src:'javascript/FlowPlayerDark.swf',
			width: 480, 
			height: 360
		},
		
		/*
			second argument is Flowplayer specific configuration. See full list:
			http://flowplayer.org/player/configuration.html
		*/
		{config: {   
			autoPlay: false,
			autoBuffering: true,
			controlBarBackgroundColor:'0x2e8860',
			initialScale: 'scale',
			//videoFile: 'http://localhost/www.alasbcn.com/img_creaciones/tres_forats.mpg.FLV'
			videoFile: 'http://www.alasbcn.com/img_creaciones/<?php  echo $_GET['file'];?>'
		}} 
	);
	</script>	
	
</head>
<div id="example"></div>

