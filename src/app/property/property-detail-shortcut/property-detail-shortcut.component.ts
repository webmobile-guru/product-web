import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { PropertyService } from '../property.service';

@Component({
  selector: 'app-property-detail-shortcut',
  templateUrl: './property-detail-shortcut.component.html',
  styleUrls: ['./property-detail-shortcut.component.scss']
})
export class PropertyDetailShortcutComponent implements OnInit {

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private propertyService: PropertyService
  ) { }

  ngOnInit() {
    this.route.params.subscribe(params => {
      const id = this.route.snapshot.paramMap.get('id');
      // Get the property and redirect to
      // the real url
      this.propertyService.getPropertyByShortId(id).subscribe(res => {
        if (res && res.url) {
          return this.router.navigateByUrl(res.url);
        }
      });
    });
  }
}
