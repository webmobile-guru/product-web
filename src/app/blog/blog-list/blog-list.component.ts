import { Component, OnInit } from '@angular/core';

declare const $: any;
@Component({
  selector: 'app-blog-list',
  templateUrl: './blog-list.component.html',
  styleUrls: ['./blog-list.component.scss']
})
export class BlogListComponent implements OnInit {
  content: string = 'A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.'

  postData = {
    id: 10,
    title: 'post Title',
    metaTitle: 'post metaTitle',
    slug: 'post slug',
    summary: 'xxx',
    publishedAt: 'timestamp',
    content: this.content,
    user: {
      id: 1,
      username: 'xxxxx',
      firstName: 'xxxxx',
      middleName: 'xxxx',
      lastName: 'xxxx',
      mobile: '+234234234234',
      email: 'xxx@gmail.com',
    },
    meta: {
      id: 1,
      key: 'xxxx',
      content: 'xxxx'
    },
    categories: [
      {
        id: 1,
        title: 'xxxx',
        metaTitle: 'xxxx',
        slug: 'xxxx',
        content: 'xxxx',
      },
      {
        id: 2,
        title: 'xxxx',
        metaTitle: 'xxxx',
        slug: 'xxxx',
        content: 'xxxx',
      },
    ],
    tags: [
      {
        id: 1,
        title: 'xxxx',
        metaTitle: 'xxxx',
        slug: 'xxxx',
        content: 'xxxx',
      },
      {
        id: 2,
        title: 'xxxx',
        metaTitle: 'xxxx',
        slug: 'xxxx',
        content: 'xxxx',
      },
    ],
    comments: [
      {
        id: 1,
        title: 'comment1',
        published: 'xxxx',
        publishedAt: 'timestamp',
        content: 'xxxx',
        user: {
          id: 1,
          username: 'xxxxx',
          firstName: 'xxxxx',
          middleName: 'xxxx',
          lastName: 'xxxx',
          mobile: '+234234234234',
          email: 'xxx@gmail.com',
        },
        parent: "IdcommentParent"
      },
      {
        id: 2,
        title: 'comment2',
        published: 'xxxx',
        publishedAt: 'timestamp',
        content: 'xxxx',
        user: {
          id: 1,
          username: 'xxxxx',
          firstName: 'xxxxx',
          middleName: 'xxxx',
          lastName: 'xxxx',
          mobile: '+234234234234',
          email: 'xxx@gmail.com',
        },
        parent: "IdcommentParent"
      }
    ]
  };

  postDatas: Array<any>=[];

  constructor() { 
    for (let i = 1; i <= 110; i++) {
      this.postDatas.push(this.postData);
    }
  }

  ngOnInit() {
    this.initialize();
  }
  // Post Slider
  initialize() {
    if ($('.post-images-slider').length > 0) {
      $('.post-images-slider').flexslider({
        animation: "slide",
        smoothHeight: true,
      });
    }
  }

}
