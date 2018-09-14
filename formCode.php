<?php

# file variables
$targetDir = "/var/www/html/uploads/";
$targetName = md5($_FILES["file"]["name"]);
$targetBinFile = $targetDir.$targetName.".bin";
$targetCFile = $targetDir.$targetName.".c";

echo("
        <html>
            <head>
                <title>RetDec Online Decompiler</title>
                 <style>
                     html {background-color: #010101;}
                     body {
                     color: green;
                     font-family: \"Courier\", \"Courier New\", sans-serif;
                     }
                 </style>
            </head>
     ");
    
echo("
     <body>
		<header>
			<center>
				<h1>RetDec Online Interface</h1>
			</center>
		</header>
	");

# see if upload was successful
if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetBinFile))
{
	# command to run/flag variables
	$commandToRun = "retdec-decompiler.py ";
	$arch = $_POST["arch"];
	$endian = $_POST["endian"];

	$rawEntryPoint = $_POST["raw-entry-point"];
	$selectFunctions = $_POST["select-functions"];
	$selectRanges = $_POST["select-ranges"];

	$keepUnreachableFunctions = $_POST["keep-unreachable-functions"];
	$keepAllBrackets = $_POST["backend-keep-all-brackets"];
	$keepLibraryFunctions = $_POST["backend-keep-library-funcs"];
	$noCompoundOperators = $_POST["backend-no-compound-operators"];
	$colorForIDA = $_POST["color-for-ida"];

	# add flag argument based on checkbox status
	if($arch != "")
	{
		$commandToRun = $commandToRun." --arch ".escapeshellarg($arch);
	}
	if($endian != "")
	{
		$commandToRun = $commandToRun." --endian ".escapeshellarg($endian);
	}

	if($rawEntryPoint != "")
	{
		$commandToRun = $commandToRun." --raw-entry-point ".escapeshellarg($rawEntryPoint);
	}
	if($selectFunctions != "")
	{
		$commandToRun = $commandToRun." --select-functions ".escapeshellarg($selectFunctions);
	}
	if($selectRanges != "")
	{
		$commandToRun = $commandToRun." --select-ranges ".escapeshellarg($selectRanges);
	}

	if($keepUnreachableFunctions === "on")
	{
		$commandToRun = $commandToRun." -k ";
	}
	if($keepAllBrackets === "on")
	{
		$commandToRun = $commandToRun." --backend-keep-all-brackets ";
	}
	if($keepLibraryFunctions === "on")
	{
		$commandToRun = $commandToRun." --backend-keep-library-funcs ";
	}
	if($noCompoundOperators === "on")
	{
		$commandToRun = $commandToRun." --backend-no-compound-operators ";
	}
	if($colorForIDA === "on")
	{
		$commandToRun = $commandToRun." --color-for-ida ";
	}

	# append fileName to command
	$commandToRun = $commandToRun.$targetBinFile;

	# append working path to command
	$commandToRun = $commandToRun." -o ".$targetCFile;


	# run commands
	$commandOutput = shell_exec("$commandToRun");
	$codeOutput = shell_exec("cat $targetCFile");

	# BUTTON CONTROLS
	echo("
         <main>
			<center>
				<button onclick=\"toggleCommandOutput()\">Toggle Decompile Command Output</button>
				<a href=\"download.php?file=".basename($targetCFile)."\"><button>Download Decompiled Code</button></a>
				<a href=\"index.html\"><button>Return To Upload</button></a>
		</center>
		");

	# commandOutput results toggle
	echo("
			<pre id=\"commandOutput\" display=\"none\" style=\":word-wrap:break-word; overflow-wrap:break-word; border:3px solid red; padding-left:3px; white-space:pre-line;\">
				<center><h3>Decompile Command Output</h3></center>
				".htmlspecialchars(str_replace($targetDir, "/path/to/", $commandOutput))."
			</pre>
		");

	# Show decompiled results 
	echo("
			<pre id=\"codeOutput\" style=\"word-wrap:break-word; overflow-wrap:break-word; border:3px solid green; padding-left:3px; white-space:pre-line\">
				<center><h3>Decompiled Code</h3></center>
				".htmlspecialchars($codeOutput)."
			</pre>
         </main>
		");
	
	# javascript functions
	echo("
			 <script>
				function toggleCommandOutput()
				{
					var element = document.getElementById(\"commandOutput\");
					if(element.style.display === \"none\")
						element.style.display = \"block\";
					else
						element.style.display = \"none\";
				}
				
			</script>
		");

}
else
{
	# file upload failed
	echo("<p>File upload failed.</p>");
	$db1 = $_FILES["file"]["error"];
	echo("<p>$db1</p>");
	echo("<p><a href=\"index.html\">Click here to return to upload page.</a></p>");
}

echo("
		<footer>
			<center>
				Web interface created by: Tristan Fletcher | Hosted by: Andrew Kramer | <a href=\"http://github.com/avast-tl/retdec\">Source code for RetDec</a> | <a href=\"https://github.com/cyclawps52/RetDec-Online\">Source code for this interface</a>
				<br>For more information: contact andrew dot kramer at dsu dot edu
			</center>
		</footer>
     </body>
     </html>
	");

?>

