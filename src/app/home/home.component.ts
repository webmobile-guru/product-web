import { Component, Inject, OnInit, PLATFORM_ID } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { SearchFormService } from '../property/search-form.service';
import { isPlatformServer } from '@angular/common';
import { Title, Meta } from '@angular/platform-browser';
import { LinkService } from '../components/links/LinkService';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'],
  providers: [LinkService]
})
export class HomeComponent implements OnInit {
  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private searchFormService: SearchFormService,
    private title: Title,
    private meta: Meta,
    private linkService: LinkService,
    @Inject(PLATFORM_ID) private platformId
  ) {}

  ngOnInit() {
    const currentUrl = this.router.url;
    const countLength = currentUrl.split('/');
    const res = countLength.filter((dt) => {
      return dt !== '' && dt;
    });
    if (res.length < 1 && !isPlatformServer(this.platformId)) {
      localStorage.clear();
      localStorage.setItem('locationNameQuery', '');
    }

    this.title.setTitle('houhaa - UAE\'s largest real estate portal for properties for sale and rent');
    this.meta.updateTag(
      {name: 'description', content: 'houhaa is the UAE’s biggest agency-owned real estate website.\ ' +
        'Find your next home through our wide range of residential and commercial for sale and for rent properties.'},
      `name='description'`);
    this.meta.updateTag({
      name: 'robots', content: 'index,follow'},
      `name='robots'`);
    this.linkService.removeTag('rel=canonical');
    this.linkService.addTag({
      rel: 'canonical', href: 'https://houhaa.com' + this.router.url
    });
    this.linkService.removeTag('rel=alternate');
    this.linkService.addTag({
      rel: 'alternate', hreflang: 'en', href: 'https://houhaa.com' + this.router.url
    });



    this.route.data.subscribe((data) => {
      // Need to alter the search form if we're on
      // rent or buy (or commercial etc..)
      if (data['searchType']) {
        this.searchFormService.setFormType(data['searchType']);
      }
    });
  }
}
