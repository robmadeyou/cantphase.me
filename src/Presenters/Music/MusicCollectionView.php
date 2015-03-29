<?php
/**
 * How is it going yo
 */

namespace Cant\Phase\Me\Presenters\Music;


use Cant\Phase\Me\Model\Music\MusicSettings;
use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;
use Rhubarb\Scaffolds\Authentication\LoginProvider;

class MusicCollectionView extends HtmlView
{
	use WithJqueryViewBridgeTrait;

	protected function getAdditionalResourceUrls()
	{
		return  [ "http://code.createjs.com/easeljs-0.7.1.min.js", "http://code.createjs.com/soundjs-0.5.2.min.js" ];
	}

	protected function printViewContent()
	{
		$settings = MusicSettings::GetSettingsForUser( (new LoginProvider())->getLoggedInUser()->UniqueIdentifier );
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
				<input id="volume" type="range" min="0" max="100" value="<?= $settings->Volume ?>">
				<div class="visualizer-slider-percentage">20%</div>
			</div>
			<div class="visualizer-content visualizer-menu-dropdown">
				<img id="visualizer-dropdown" src="/static/image/songDropdownMenu.png" width="20px" height="20px"/>
			</div>
			<div class="_vdo visualizer-dropdown-overlay">
				<div class="_vdo visualizer-dropdown-overlay-inner" id="visualizer-main-selection">
					<input class="_vdo" type="text" id="searchIn" placeholder="search" >
					<div class="_vdo" id="search">
					</div>
					<div class="_vdo visualizer-dropdown-items">
						<span class="_vdo visualizer-dropdown-item" id="visualizer-dropdown-new-song">+ Add new Song</span>
						<span class="_vdo visualizer-dropdown-item">+ Browse Music</span>
						<span class="_vdo visualizer-dropdown-item" id="visualizer-dropdown-visualizer-toggle">+ Visualizer [ <?= $settings->ShowVisualizer ? "On" : "Off" ?> ]</span>
						<span class="_vdo visualizer-dropdown-item">+ Return to menu</span>
					</div>
				</div>
				<div class="_vdo visualizer-dropdown-overlay-inner visualizer-dropdown-items" id="visualizer-add-song">
					<div class="_vdo">
						<img class="_vdo visualizer-dropdown-add-song-back-button" src="/static/image/songBackButton.png">
					</div>
					<p class="_vdo visualizer-dropdown-item visualizer-title">Add a new song</p>
					<input class="_vdo visualizer-dropdown-item song-upload" placeholder="Song/Playlist" type="text" id="pullUrl">
					<input class="_vdo visualizer-dropdown-item song-upload" placeholder="Custom Prefix" type="text" id="pullPrefix">
					<input class="_vdo visualizer-dropdown-item song-upload" placeholder="Tags" type="text" id="pullTags">
				</div>
			</div>
		</div>
		<?php
			if( $settings->ShowVisualizer )
			{
				print '<canvas id="barCanvas"></canvas>';
			}
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