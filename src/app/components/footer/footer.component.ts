import { Component, Input, OnInit, Output, EventEmitter } from '@angular/core';
import { SearchStateService } from '../../property/property-search/search-state.service';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {
  @Input() properties;
  @Output() setLocationToSearch = new EventEmitter<any>();
  clickListingSearchHistory = '';
  queryResultLocation: object;
  locname: any;

  constructor(public searchStateService: SearchStateService) {}

  queryState: any = {};
  ngOnInit() {}

  searchParamsWithLocation(location: string): object {
    const newParams = { ...this.queryResultLocation };
    newParams['locations'] = location;
    return newParams;
  }
}
