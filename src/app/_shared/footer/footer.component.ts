import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {

  recentComments = [
    {username: 'Maria', link: '#', postname: 'Designer Desk Essentials'},
    {username: 'John', link: '#', postname: 'Realistic Business Card Mockup'},
    {username: 'Andy', link: '#', postname: 'Eco bag Mockup'},
    {username: 'Jack', link: '#', postname: 'Bottle Mockup'},
    {username: 'Mark', link: '#', postname: 'Our trip to the Alps'},
  ];

  blogCategories = [
    {categoryName: 'Photography - 7', link: '#'},
    {categoryName: 'Photography - 7', link: '#'},
    {categoryName: 'Photography - 7', link: '#'},
    {categoryName: 'Photography - 7', link: '#'},
    {categoryName: 'Photography - 7', link: '#'},
  ]

  popularPosts = [
    { image: 'assets/images/rp-1.jpg', link: '#', title: 'Designer Desk Essentials', meta: '23 January', titleLink: '#'},
    { image: 'assets/images/rp-1.jpg', link: '#', title: 'Designer Desk Essentials', meta: '23 January', titleLink: '#'},
    { image: 'assets/images/rp-1.jpg', link: '#', title: 'Designer Desk Essentials', meta: '23 January', titleLink: '#'},
  ]

  socialData = [
    { name: 'facebook', url: ''},
    { name: 'twitter', url: ''},
    { name: 'Instagram', url: ''},
    { name: 'Youtube', url: ''}
  ]
  
  constructor() { }

  ngOnInit() {
  }

}
