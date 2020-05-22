import { Component, OnInit, Input } from '@angular/core';
import { Router } from '@angular/router';

declare const $: any;

@Component({
  selector: 'app-blog-post',
  templateUrl: './blog-post.component.html',
  styleUrls: ['./blog-post.component.scss']
})
export class BlogPostComponent implements OnInit {
  @Input() postData: any;
  commentCounter: number;

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
    this.commentCounter = this.postData.comments.length;
  }

  ngAfterViewInit() {
    $('.post-entry').readmore({
      speed: 75,
      collapsedHeight: 125,
      moreLink: '<a class="more-link" href="#">Read more</a>',
      lessLink: '<a class="less-link" href="#">Read less</a>'
    });
  }

  goBlogDetail(id: string) {
    this.router.navigateByUrl('blog/detail/' + id);
  }
}
