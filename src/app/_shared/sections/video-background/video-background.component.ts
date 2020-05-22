import { Component, OnInit } from '@angular/core';

import { NgxSpinnerService } from "ngx-spinner";

declare const $: any;
@Component({
  selector: 'app-video-background',
  templateUrl: './video-background.component.html',
  styleUrls: ['./video-background.component.scss']
})
export class VideoBackgroundComponent implements OnInit {

  youtubeList = [
    { videoURL: "_z-1fTlSDF0", containment: '.home-section', autoPlay: true, mute: false, startAt: 18, opacity: 1, loop: true, addRaster: true, showControls: false },
    { videoURL: "bNucJgetMjE", containment: '.home-section', autoPlay: true, mute: false, startAt: 18, opacity: 1, loop: false, addRaster: false, showControls: false },
    { videoURL: "_z-1fTlSDF0", containment: '.home-section', autoPlay: true, mute: false, startAt: 18, opacity: 1, loop: true, addRaster: true, showControls: false }
  ];

  constructor(
    private spinner: NgxSpinnerService
  ) { }

  ngOnInit() {
    this.spinner.show();
    setTimeout(() => {
      this.spinner.hide();
    }, 1000);

    this.initialize();

    // Youtube video background
    // https://github.com/pupunzi/jquery.mb.YTPlayer/wiki
    $(() => {
      // $(".video-player").mb_YTPlayer();
      $("#video-player").YTPlaylist(this.youtubeList, true, function (video) {
        if (video.videoData) {
          console.log('video plays:123123123')
        }
      });
      $("#video-player").on("YTPStart", (e) => {
        // this.spinner.hide();
        console.log('video played');
        $('.video-player').YTPMute();
      })
    });

    $('#video-play').click(function (event) {
      event.preventDefault();
      if ($(this).hasClass('fa-play')) {
        $('.video-player').playYTP();
      } else {
        $('.video-player').pauseYTP();
      }
      $(this).toggleClass('fa-play fa-pause');
      return false;
    });

    $('#video-volume').click(function (event) {
      event.preventDefault();
      if ($(this).hasClass('fa-volume-off')) {
        $('.video-player').YTPUnmute();
      } else {
        $('.video-player').YTPMute();
      }
      $(this).toggleClass('fa-volume-off fa-volume-up');
      return false;
    });
  }

  initialize() {
    let homeSection = $('.home-section');
    let navbar = $('.navbar-custom');
    let navHeight = navbar.height()
    buildHomeSection(homeSection);

    $(window).resize(function () {
      var width = Math.max($(window).width(), window.innerWidth);
      buildHomeSection(homeSection);
    });

    $(window).scroll(function () {
      effectsHomeSection(homeSection, this);
      navbarAnimation(navbar, homeSection, navHeight);
    });

    navbarAnimation(navbar, homeSection, navHeight);

    function effectsHomeSection(homeSection, scrollTopp) {
      if (homeSection.length > 0) {
        var homeSHeight = homeSection.height();
        var topScroll = $(document).scrollTop();
        if ((homeSection.hasClass('home-parallax')) && ($(scrollTopp).scrollTop() <= homeSHeight)) {
          homeSection.css('top', (topScroll * 0.55));
        }
        if (homeSection.hasClass('home-fade') && ($(scrollTopp).scrollTop() <= homeSHeight)) {
          var caption = $('.caption-content');
          caption.css('opacity', (1 - topScroll / homeSection.height() * 1));
        }
      }
    }

    function navbarAnimation(navbar, homeSection, navHeight) {
      var topScroll = $(window).scrollTop();
      if (navbar.length > 0 && homeSection.length > 0) {
        if (topScroll >= navHeight) {
          navbar.removeClass('navbar-transparent');
        } else {
          navbar.addClass('navbar-transparent');
        }
      }
    }

    function buildHomeSection(homeSection) {
      if (homeSection.length > 0) {
        if (homeSection.hasClass('home-full-height')) {
          homeSection.height($(window).height());
        } else {
          homeSection.height($(window).height() * 0.85);
        }
      }
    }

    let module = $('.home-section, .module, .module-small, .side-image');
    module.each(function(i) {
        if ($(this).attr('data-background')) {
            $(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
        }
    });
  }

}
