<?php
//laptop commit test
if (!isset($argv[1])) {
	die("please specify how many images you need\n usage: makeArt.php <# of images>\n");
}

foreach ($argv as $value) {
	makeArt($value);
}

function makeArt ($times = 1) {
	$count = 1;
	do {
		init();
		$count++;
	} while ($count < $times);
}
function init () {
	$filename = makeFileName();
	print "processing:{$filename}\n";
	//make image
	makeImage($filename);
}
function makeImage ($filename) {
	//loop through config
	$configToUse = rand(1,9);
	print "creating image $filename from config \"{$configToUse}\"\n";
	$cmd = "";
	$cmd = "evolvotron_mutate < ./configs/evolvotron/$cmd{$configToUse}.xml | evolvotron_render -s 1000x1000 ./masters/{$filename}.png";

print $cmd;
	exec($cmd);
	addFilter($filename);
}
function makeFileName() { //guess what this does ?
	$fileName = date('m_d_Y') . "_" . time();
	return $fileName;
}

function addFilter ($filename) {
	$filename = "./masters/{$filename}.png";

	$arrFilters = array (
		"gotham" => "convert {$filename} -modulate 120,10,100 -fill '#222b6d' -colorize 20 -gamma 0.5 -contrast -contrast {$filename}",
		"kalvin" => "convert {$filename} -auto-gamma -modulate 120,50,100 -size 1000x1000 -fill 'rgba(255,153,0,0.5)' -draw 'rectangle 0,0 1000,1000'-compose multiply {$filename}",
		"lomo" => "convert $filename -channel R -level 33% -channel G -level 33% $filename",
	);
exec($arrFilters['lomo']);
	exec($arrFilters['gotham']);

}
//generate image
//evolvotron_mutate < 1.xml | evolvotron_render -s 1000x1000 testimage2.png
//add effects to image
//blur
//convert -blur 6x6  testimage2.png blur.jpeg	
//maybe instagram filters
?>
