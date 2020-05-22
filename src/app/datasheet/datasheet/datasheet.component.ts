import { Component, OnInit } from '@angular/core';
import { TreeviewItem, TreeviewConfig } from 'ngx-treeview';
import { Router } from '@angular/router';

@Component({
  selector: 'app-datasheet',
  templateUrl: './datasheet.component.html',
  styleUrls: ['./datasheet.component.scss']
})
export class DatasheetComponent implements OnInit {
  dropdownEnabled = true;
  items: TreeviewItem[];
  values: number[];

  config = TreeviewConfig.create({
    hasAllCheckBox: true,
    hasFilter: true,
    hasCollapseExpand: true,
    decoupleChildFromParent: false,
    maxHeight: 800
  });

  datasheetList = [
    {
      id: 1,
      workTitle: 'Corporate Identity',
      workDescr: 'Illustration',
      image: 'assets/images/portfolio/grid-portfolio1.jpg'
    },
    {
      id: 2,
      workTitle: 'Disk Cover',
      workDescr: 'Illustration',
      image: 'assets/images/portfolio/grid-portfolio3.jpg'
    },
    {
      id: 3,
      workTitle: 'Corporate Identity',
      workDescr: 'Illustration',
      image: 'assets/images/portfolio/grid-portfolio4.jpg'
    },
    {
      id: 4,
      workTitle: 'Disk Cover',
      workDescr: 'Illustration',
      image: 'assets/images/portfolio/grid-portfolio5.jpg'
    },
    {
      id: 5,
      workTitle: 'Corporate Identity',
      workDescr: 'Illustration',
      image: 'assets/images/portfolio/grid-portfolio1.jpg'
    },
    {
      id: 6,
      workTitle: 'Disk Cover',
      workDescr: 'Illustration',
      image: 'assets/images/portfolio/grid-portfolio3.jpg'
    },
    {
      id: 7,
      workTitle: 'Corporate Identity',
      workDescr: 'Illustration',
      image: 'assets/images/portfolio/grid-portfolio1.jpg'
    },
    {
      id: 8,
      workTitle: 'Disk Cover',
      workDescr: 'Illustration',
      image: 'assets/images/portfolio/grid-portfolio3.jpg'
    },
  ]

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
    const Category = new TreeviewItem({
      text: 'Category', value: 1, collapsed: false, checked: false, children: [
        { text: 'Category 1', value: 11, checked: false },
        { text: 'Category 2', value: 12, checked: false },
        { text: 'Category 3', value: 13, checked: false },
        { text: 'Category 4', value: 14, checked: false },
        { text: 'Category 5', value: 15, checked: false },
        { text: 'Category 6', value: 16, checked: false }
      ]
    });
    const Size = new TreeviewItem({
      text: 'Size', value: 2, collapsed: false, children: [
        { text: 'Small', value: 21, checked: false },
        { text: 'Medium', value: 22, checked: false },
        { text: 'Large', value: 23, checked: false },
        { text: 'X-Large', value: 24, checked: false },
        { text: 'XX-Large', value: 25, checked: false },
      ]
    });
    const Color = new TreeviewItem({
      text: 'Color', value: 3, collapsed: true, children: [
        { text: 'Black', value: 31, checked: false },
        { text: 'Red', value: 32, checked: false }
      ]
    });
    const Price = new TreeviewItem({
      text: 'Price', value: 4, collapsed: true, children: [
        { text: '$1000', value: 41, checked: false },
        { text: '$10000', value: 42, checked: false }
      ]
    });
    this.items = [Category, Size, Color, Price];
  }

  onFilterChange(value: string) {
    console.log('filter:', value);
  }

  onSelectedChange($event) {
    console.log('select chnage: ', $event)
  }

  goDatasheetDetail(id: string) {
    this.router.navigateByUrl('datasheet/detail/' + id);
  }

}
