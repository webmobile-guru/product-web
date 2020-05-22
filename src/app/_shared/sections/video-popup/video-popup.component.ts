import { Component, OnInit } from '@angular/core';

declare const $: any;
@Component({
  selector: 'app-video-popup',
  templateUrl: './video-popup.component.html',
  styleUrls: ['./video-popup.component.scss']
})
export class VideoPopupComponent implements OnInit {

  constructor() { }

  ngOnInit() {
    // https://dimsemenov.com/plugins/magnific-popup/documentation.html
    $('.video-pop-up').magnificPopup({
      items: [
        {
          src: 'https://www.youtube.com/watch?v=TTxZj3DZiIM',
          type: 'iframe'
        },
        {
          src: 'https://www.youtube.com/watch?v=bNucJgetMjE',
          type: 'iframe'
        },
      ],
      gallery: {
        enabled: true
      }
    });

  }

}
