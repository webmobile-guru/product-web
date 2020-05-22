import { Component, Inject, OnInit, PLATFORM_ID } from '@angular/core';
import { isPlatformServer } from '@angular/common';
import { SearchFormService } from '../../property/search-form.service';
import { SearchStateService } from '../../property/property-search/search-state.service';
import { sortingOptions } from '../../property/globals';

@Component({
  selector: 'app-navs',
  templateUrl: './navs.component.html',
  styleUrls: ['./navs.component.css']
})
export class NavsComponent implements OnInit {
  sortDefault = sortingOptions[0].value;
  
  constructor(public searchFormService: SearchFormService,
    @Inject(PLATFORM_ID) private platformId,
    private searchStateService: SearchStateService) { }

  ngOnInit() {
    setTimeout(() => {
      this.setScript();
    }, 200);
  }

  updateSortEvent() {
    this.searchStateService.setNav();
    // On Nav click update Sort As default  - 'FEATURED'
    this.searchStateService.sortBy = sortingOptions[0].value;
  }

  setScript() {
    const toggleNavigation = function () {
      if (!isPlatformServer(this.platformId)) {
        // If not the server
        const navElem = document.querySelector('.nav');

        if (!navElem.classList.contains('js-open')) {
          navElem.classList.add('js-open');
          const body = document.getElementsByTagName('body');
          body[0].style.overflow = 'hidden';
        } else {
          navElem.classList.remove('js-open');
          const body = document.getElementsByTagName('body');
          body[0].style.overflow = 'scroll';
        }
      }
    };

    if (!isPlatformServer(this.platformId)) {
      const openNavBtnElem = document.querySelector('.header__hamburger-btn');
      const closeNavBtnElem = document.querySelector('.nav__close-btn');

      openNavBtnElem.addEventListener('click', toggleNavigation);
      closeNavBtnElem.addEventListener('click', toggleNavigation);
    }
  }
}
