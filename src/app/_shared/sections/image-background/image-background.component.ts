import { Component, OnInit, Input, ViewChild, ElementRef, Renderer2 } from '@angular/core';

declare const $: any;
@Component({
  selector: 'app-image-background',
  templateUrl: './image-background.component.html',
  styleUrls: ['./image-background.component.scss']
})
export class ImageBackgroundComponent implements OnInit {

  @ViewChild('section', { static: false }) section: ElementRef;

  @Input() moduleTitle0?: string;
  @Input() moduleTitle?: string;
  @Input() moduleSubTitle?: string;
  @Input() subContent?: string;
  @Input() backgroundImage?: string = 'assets/images/section-4.jpg';
  constructor(
    private renderer: Renderer2
  ) { }

  ngOnInit() {
  }

  ngAfterViewInit() {
    // console.log('this is section: ', this.section);
    this.renderer.setStyle(this.section.nativeElement, 'background-image', "url(" + this.backgroundImage + ")");
  }

}
