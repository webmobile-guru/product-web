import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

  menuItems = [
    {title: 'HOME', path: '/home'},
    {title: 'INSPIRATION', path: '/inspiration'},
    {title: 'BLOG', path: '/blog'},
    {title: 'DATA SHEET', path: '/datasheet'},
    {title: 'LOGIN/REGISTER', path: '/auth'},
  ]
  constructor(
    private router: Router
  ) { }

  ngOnInit() {
  }

  goUrl(url: string): void {
    this.router.navigateByUrl(url);
  }

}
