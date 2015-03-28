<?php
/**
 * How is it going yo
 */

namespace Cant\Phase\Me\Presenters\Music;


use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class MusicCollectionView extends HtmlView
{
	use WithJqueryViewBridgeTrait;

	protected function printViewContent()
	{
		/*
		 <div id="overlay"></div>
		<div id="outerPullForm">
			<a href="#" id="close"><img src="/static/image/close.png" width="32" height="32" ></a>
			<div id="innerPullForm">
				<div id="left">
					<b>Insert URL</b><br>
					<input type="text" id="pullUrl" class="textbox" placeholder="This can be Youtube/Soundcloud playlist; single video or even an artist!"><br><br>
					<b>Enable Smart Title </b><input title="This will put the custom name as the start of every song if the custom name isn\'t already added to the song name" type="checkbox" id="pullSmartTitle"><br><br>
					<b>Custom Name?</b><i>(Leave blank if none)</i><br>
					<input type="text" id="pullPrefix" class="textbox" placeholder="Custom name will be used to identify the song"><br><br>
					<b>Genres/Tags</b><br>
					<textarea id="pullTags" placeholder="Enter the tags you would like to add to songs from the URL; you will be able to search by them later on!"></textarea>
				</div>
				<div id="right">
					<b>Include Notes?</b><i>(Little self promotion is ok here :))</i><br>
					<textarea id="pullNotes" placeholder="Yo yo yo; notes are cool!"></textarea>
				</div>
			</div>
			<button type="button" id="finalizePull">Upload!</button>
		</div>
		<div id="holder">
			<div id="titleBar">
				<marquee id="songTitle"></marquee>
				<button type="button" id="nextButton" onclick="playNextSong()" >Next song!</button><input id="volume" type="range" min="0" max="100">
			</div>
			<div id="bars">
				<canvas id="barCanvas" height="1000"></canvas>
			</div>
			<div id="interactive">
				<div id="imgLocation" class="box" >
					<img id="img" src="">
				</div>
				<div id="searchLocation" class="box" >
					<input type="text" id="searchIn" placeholder="search" >
					<div id="search">
					</div>
				</div>
				<div id="downloadLocation" class="box">
					<button type="submit" id="pull">Click me to download songs to the server</button>
					<div id="pullResults">
					</div>
				</div>
			</div>
		</div>
		 */
		?>
		<div id="visualizer-overlay">
			<img class="visualizer-artwork" src="" id="img"/>
			<div class="visualizer-center-split">
				<div class="visualizer-center-top">
					<img src="/static/image/songButtonPrev.png" id="prevButton" />
					<marquee id="songTitle"></marquee>
					<img src="/static/image/songButtonNex.png" id="nextButton" />
				</div>
				<input id="volume" type="range" min="0" max="100" value="20">
				<div class="visualizer-slider-percentage">20%</div>
			</div>
			<div class="visualizer-content visualizer-menu-dropdown">
				<img id="visualizer-dropdown" src="/static/image/songDropdownMenu.png" width="20px" height="20px"/>
			</div>
		</div>
		<canvas id="barCanvas"></canvas>
		<div class="_vdo visualizer-dropdown-overlay">
			<input class="_vdo" type="text" id="searchIn" placeholder="search" >
			<div class="_vdo" id="search">
			</div>
		</div>
		<?php
	}

	/**
	 * Implement this and return __DIR__ when your ViewBridge.js is in the same folder as your class
	 *
	 * @returns string Path to your ViewBridge.js file
	 */
	public function getDeploymentPackageDirectory()
	{
		return __DIR__;
	}

}