import { Component, OnInit, ViewChild, ElementRef, Input, Renderer2 } from '@angular/core';

declare const $: any;
@Component({
  selector: 'app-slide-text-image',
  templateUrl: './slide-text-image.component.html',
  styleUrls: ['./slide-text-image.component.scss']
})
export class SlideTextImageComponent implements OnInit {

  @ViewChild('section', { static: false }) section: ElementRef;

  @Input() backgroundImage?: string = 'assets/images/testimonial_bg.jpg';

  constructor(
    private renderer: Renderer2
  ) { }

  ngOnInit() {
    this.initialize();
  }

  ngAfterViewInit() {
    console.log('this is section: ', this.section)
    this.renderer.setStyle(this.section.nativeElement, 'background-image', "url(" + this.backgroundImage + ")");
  }

  initialize() {
    if ($('.testimonials-slider').length > 0) {
      $('.testimonials-slider').flexslider({
        animation: "slide",
        smoothHeight: true
      });
    }
  }
}
