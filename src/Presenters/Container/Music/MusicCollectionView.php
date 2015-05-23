<?php

namespace Cant\Phase\Me\Presenters\Container\Music;

use Cant\Phase\Me\Model\Music\MusicSettings;
use Rhubarb\Crown\Layout\LayoutModule;
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
		$settings = MusicSettings::GetSettingsForUser( ( new LoginProvider() )->getLoggedInUser()->UniqueIdentifier );
		?>
		<div id="content" class="wrapper">
			<div class="top">
				<div class="main-buttons">
					<img class="main-button left" src="/static/image/topmenuHome.png">
					<img class="main-button left" src="/static/image/topmenuProfile.png">
					<img class="main-button left" src="/static/image/topmenuMusic.png">
					<img class="main-button right" src="/static/image/topmenuLogout.png">
					<img class="main-button right volume" id="volumeDown" src="/static/image/topmenumaxVolume.png">
					<input class="main-button volume-slider right" id="volume" type="range" min="0" max="100" value="<?= $settings->Volume ?>">
					<img class="main-button right volume" id="volumeUp" src="/static/image/topmenuminVolume.png">
				</div>
			</div>
			<div class="top-bottom">&nbsp;&nbsp;&nbsp;&nbsp
				<span class="top-bar-link unselectable bar-selected">Visualizer</span><span class="unselectable"> | </span>
				<span class="top-bar-link unselectable">Song list</span><span class="unselectable"> | </span>
				<span class="top-bar-link unselectable">Favorites</span><span class="unselectable"> | </span>
				<span class="top-bar-link unselectable">Playlists</span>
			</div>
			<img id="toolbar-selected" src="/static/image/selectedToolbar.png">
			<div id="pages">
				<div class="page" id="visualizer">
					<img  src="" id="img"/>
					<div class="visualizer-center-top">
						<img class="music-controls" src="/static/image/musicnextandbackButton.png" id="prevButton" />
						<marquee class="music-controls" id="songTitle"></marquee>
						<img class="music-controls flip" src="/static/image/musicnextandbackButton.png" id="nextButton"/>
					</div>
					<canvas id="barCanvas"></canvas>
				</div>
				<div class="page hidden">
					This is Song list
				</div>
				<div class="page hidden">
					This is Favorites
				</div>
				<div class="page hidden">
					This is Playlists
				</div>
			</div>
			<div class="push"></div>
		</div>
		<div class="footer">
		</div>
		<!--<div id="visualizer-overlay">
			<div class="visualizer-artwork">
				<img  src="" id="img"/>
				<div class="sound-controls">
					<div class="sound-control" id="favorite-button">
						<img src="/static/image/songFavouriteUnSelect.png"/>
					</div>
					<div class="sound-control" id="stop-button">
						<img src="/static/image/songButtonStop.png"/>
					</div>
					<div class="sound-control" id="play-button">
						<img src="/static/image/songButtonPlay.png"/>
					</div>
					<div class="sound-control" id="pause-button">
						<img src="/static/image/songButtonPause.png"/>
					</div>
				</div>
			</div>
			<div class="visualizer-center-split">
				<div class="visualizer-center-top">
					<img src="/static/image/songButtonPrev.png" id="prevButton" />
					<marquee id="songTitle"></marquee>
					<img src="/static/image/songButtonNex.png" id="nextButton" />
				</div>
				<input id="volume" type="range" min="0" max="100" value="<?/*= $settings->Volume */?>">
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
						<span class="_vdo visualizer-dropdown-item" id="visualizer-dropdown-browse">+ Browse Music</span>
						<span class="_vdo visualizer-dropdown-item" id="visualizer-dropdown-visualizer-toggle">+ Visualizer [ <?/*= $settings->ShowVisualizer ? "On" : "Off" */?> ]</span>
						<?/*= $settings->ShowVisualizer ? '<span class="_vdo visualizer-dropdown-item" id="visualizer-dropdown-settings">+ Visualizer Settings</span>' : '' */?>
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
		</div>-->
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