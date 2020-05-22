import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { InspirationListComponent } from './inspiration-list/inspiration-list.component';
import { InspirationDetailComponent } from './inspiration-detail/inspiration-detail.component';
import { Routes, RouterModule } from '@angular/router';
import { SectionsModule } from '../_shared/sections/sections.module';
import { RelativeItemsComponent } from './cpnts/relative-items/relative-items.component';

const routes: Routes = [
  {
    path: '',
    component: InspirationListComponent
  },
  {
    path: 'detail/:id',
    component: InspirationDetailComponent
  },
];

@NgModule({
  declarations: [
    InspirationListComponent,
    InspirationDetailComponent,
    RelativeItemsComponent
  ],
  imports: [
    CommonModule,
    SectionsModule,
    RouterModule.forChild(routes)
  ]
})
export class InspirationModule { }
