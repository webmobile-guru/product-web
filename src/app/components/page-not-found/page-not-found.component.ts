import { Component, Inject, OnInit, PLATFORM_ID } from '@angular/core';
import { isPlatformServer } from '@angular/common';

@Component({
  selector: 'app-page-not-found',
  templateUrl: './page-not-found.component.html',
  styleUrls: ['./page-not-found.component.scss']
})
export class PageNotFoundComponent implements OnInit {
  constructor(@Inject(PLATFORM_ID) private platformId) {}

  ngOnInit() {}

  ngAfterContentChecked() {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    let element = document.getElementById('notfound');
    element.scrollIntoView();
  }
}
