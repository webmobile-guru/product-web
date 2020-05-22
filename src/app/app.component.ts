import { Component, Inject, OnInit, PLATFORM_ID } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
import { isPlatformServer } from '@angular/common';

declare let ga: Function;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'Prop Search';

  constructor(private router: Router, @Inject(PLATFORM_ID) private platformId) {
    this.router.events.subscribe((event) => {
      if (!isPlatformServer(this.platformId)) {
        // If not the server
        if (event instanceof NavigationEnd) {
          ga('set', 'page', event.urlAfterRedirects);
          ga('send', 'pageview');
        }
      }
    });
  }
}
