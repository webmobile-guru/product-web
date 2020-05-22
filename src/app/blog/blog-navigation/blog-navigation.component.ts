import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-blog-navigation',
  templateUrl: './blog-navigation.component.html',
  styleUrls: ['./blog-navigation.component.scss']
})
export class BlogNavigationComponent implements OnInit {

  blogCategories = [
    { id: 1, title: 'blog category 1', metaTitle: 'metaC1', slug: 'blog slug', content: 'blog content' },
    { id: 1, title: 'blog category 1', metaTitle: 'metaC1', slug: 'blog slug', content: 'blog content' },
    { id: 1, title: 'blog category 1', metaTitle: 'metaC1', slug: 'blog slug', content: 'blog content' },
    { id: 1, title: 'blog category 1', metaTitle: 'metaC1', slug: 'blog slug', content: 'blog content' },
  ];

  postData = {
    id: 10,
    title: 'post Title',
    metaTitle: 'post metaTitle',
    slug: 'post slug',
    summary: 'xxx',
    publishedAt: 'timestamp',
    content: 'content',
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

  blogTags = [
    {
      "id": 1,
      "title": "xxxxxx",
      "metaTitle": "xxxxxx",
      "slug": "xxxxxx",
      "content": "xxxxxx"
    },
    {
      "id": 2,
      "title": "xxxxxx",
      "metaTitle": "xxxxxx",
      "slug": "xxxxxx",
      "content": "xxxxxx"
    },
    {
      "id": 3,
      "title": "xxxxxx",
      "metaTitle": "xxxxxx",
      "slug": "xxxxxx",
      "content": "xxxxxx"
    },
    {
      "id": 4,
      "title": "xxxxxx",
      "metaTitle": "xxxxxx",
      "slug": "xxxxxx",
      "content": "xxxxxx"
    },
  ];

  recentComments = [
    {
      "id": 1,
      "title": "xxxxxx",
      "published": "xxxxxx",
      "publishedAt": "timestamp",
      "content": "xxxxxx",
      "user": {
        "id": 1,
        "firstName": "xxxxxxx",
        "middleName": "xxxxxxx",
        "lastName": "xxxxxxx",
        "mobile": "+34123456789",
        "email": "xxxxxxx@gmail.com"
      }
    },
    {
      "id": 2,
      "title": "xxxxxx",
      "published": "xxxxxx",
      "publishedAt": "timestamp",
      "content": "xxxxxx",
      "user": {
        "id": 2,
        "username": "xxxxxxx",
        "firstName": "xxxxxxx",
        "middleName": "xxxxxxx",
        "lastName": "xxxxxxx",
        "mobile": "+34123456789",
        "email": "xxxxxxx@gmail.com"
      },
      "parent": "IdCommentParent"
    }

  ];

  popularPosts = [];
  constructor() { }

  ngOnInit() {
    for (let index = 0; index < 3; index++) {
      this.popularPosts.push(this.postData);
    }
  }

}
