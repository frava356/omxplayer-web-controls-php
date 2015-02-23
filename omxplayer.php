<?php
require_once 'cfg.php';
mb_internal_encoding('UTF-8');
setlocale(LC_ALL, 'ru_RU.UTF-8');
?>
<html>
	<head>
		<title>PHP OMXPlayer Control</title>
		<style type="text/css">
			.error{ color:red; font-weight:bold; }
			.button{ height: 50px; width: 85px; }
			#nextc, #prevc{
				padding-top: 15px;
			}
			
			#res{
				height: 44px;
				width: 168px;
				padding: 2px;
				float: left;
				border: 1px solid grey;
				margin-right: 4px;
			}

			.errormsg{
				color: red;
			}
			
			.normalmsg{
				color: black;
			}

		</style>
		<script src="JsHttpRequest.js"></script>
		<script>
			function omxajax(act) {

				if (act == 'play') {
					var arg=document.getElementById('selected_file').value;
					//alert (arg);
				}

				JsHttpRequest.query(
				'omx_control.php',
				{
					"act": act,
					"arg": arg
				},
				function(result, errors) {
					if (result['err']) {
						document.getElementById('res').innerHTML = result['err'];
						document.getElementById('res').className = 'errormsg';
						//alert (result['err']);
					} else {
						if (result) {
							document.getElementById('res').innerHTML = result['res'];
							document.getElementById('res').className = 'normalmsg';
						}
					}
				},
				true //disable caching
				);

			}
		</script>
	</head>
	<body>
		<center>
			<?php
			$files = glob(PATH.'/{*.[mM][kK][vV],*.[aA][vV][iI],*.[mM][pP][4],*.[mM][pP][3]}', GLOB_BRACE | GLOB_MARK);
			//print_r($files);
			$vids = array_filter ($files, function ($file) { if (substr($file,-1) != '/') return true;} ); //filter out directories
			?>
			<select id="selected_file">
				<?php
				foreach ($vids as $key=>$val) {
					echo '<option value="'.$val.'">'.basename($val).'</option>';
				}
				?>
			</select>

			<table cellspacing="5" cellpadding="0" border="0">
				<tr>
					<td>
						<button type="button" class="button" onclick="omxajax('voldown');">VOLUME -</button>
						<button type="button" class="button" onclick="omxajax('play');">PLAY</button>
						<button type="button" class="button" onclick="omxajax('volup');">VOLUME +</button>
					</td>
				</tr>
				<tr>
					<td>
						<button type="button" class="button" onclick="omxajax('seek-30');">SEEK -30</button>
						<button type="button" class="button" onclick="omxajax('pause');">PAUSE</button>
						<button type="button" class="button" onclick="omxajax('seek30');">SEEK +30</button>
					</td>
				</tr>
				<tr>
					<td>
						<button type="button" class="button" onclick="omxajax('seek-600');">SEEK -600</button>
						<button type="button" class="button" onclick="omxajax('stop');">STOP</button>
						<button type="button" class="button" onclick="omxajax('seek600');">SEEK +600</button>
					</td>
				</tr>
				<tr><td colspan="3"><hr></td></tr>
				<tr>
					<td>
						<button type="button" class="button" onclick="omxajax('speedup');">SPEED +</button>
						<button type="button" class="button" onclick="omxajax('nextchapter');" id="nextc">NEXT CHAPTER</button>
						<button type="button" class="button" onclick="omxajax('nextaudio');">NEXT AUDIO</button>
					</td>
				</tr>
				<tr>
					<td>
						<button type="button" class="button" onclick="omxajax('speeddown');">SPEED -</button>
						<button type="button" class="button" onclick="omxajax('prevchapter');" id="prevc">PREV CHAPTER</button>
						<button type="button" class="button" onclick="omxajax('prevaudio');">PREV AUDIO</button>
					</td>
				</tr>
				<tr><td colspan="3"><hr></td></tr>
				<tr>
					<td>
						<button type="button" class="button" onclick="omxajax('prevsubtitles');">PREV SUBTITLES</button>
						<button type="button" class="button" onclick="omxajax('togglesubtitles');">TOGGLE SUBTITLES</button>
						<button type="button" class="button" onclick="omxajax('nextsubtitles');">NEXT SUBTITLES</button>
					</td>
				</tr>
				<tr><td colspan="3"><hr></td></tr>
				<tr>
					<td>
						<div id="res"></div>
						<a href="setup.php?path=<?php echo PATH;?>"><button type="button" class="button" >SETUP</button></a>
					</td>
				</tr>
			</table>

		</center>

	</body>
</html>

