import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ImageBackgroundComponent } from './image-background/image-background.component';
import { VideoBackgroundComponent } from './video-background/video-background.component';
import { VideoPopupComponent } from './video-popup/video-popup.component';
import { LayoutListImagesComponent } from './layout-list-images/layout-list-images.component';

import { NgxSpinnerModule } from "ngx-spinner";
import { LastBlogsComponent } from './last-blogs/last-blogs.component';
import { GetInTouchComponent } from './get-in-touch/get-in-touch.component';
import { NgxPaginationModule } from 'ngx-pagination';

@NgModule({
  declarations: [
    ImageBackgroundComponent,
    VideoBackgroundComponent,
    VideoPopupComponent,
    LayoutListImagesComponent,
    LastBlogsComponent,
    GetInTouchComponent
  ],
  imports: [
    CommonModule,
    NgxSpinnerModule,
    NgxPaginationModule
  ],
  exports: [
    ImageBackgroundComponent,
    VideoBackgroundComponent,
    VideoPopupComponent,
    LayoutListImagesComponent,
    LastBlogsComponent,
    GetInTouchComponent
  ]
})
export class SectionsModule { }
