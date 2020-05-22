import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { BlogDetailComponent } from './blog-detail/blog-detail.component';
import { BlogListComponent } from './blog-list/blog-list.component';
import { SectionsModule } from '../_shared/sections/sections.module';
import { BlogPostComponent } from './cpnts/blog-post/blog-post.component';
import { SlideblogPostComponent } from './cpnts/slideblog-post/slideblog-post.component';
import { BlogComponent } from './blog.component';
import { BlogNavigationComponent } from './blog-navigation/blog-navigation.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgxPaginationModule } from 'ngx-pagination';
const routes: Routes = [
  {
    path: '',
    component: BlogComponent,
    children: [
      {
        path: '',
        component: BlogListComponent
      },
      {
        path: 'detail/:id',
        component: BlogDetailComponent
      },
      
    ]
  },
  
];

@NgModule({
  declarations: [ 
    BlogListComponent,
    BlogDetailComponent,
    BlogPostComponent,
    SlideblogPostComponent,
    BlogComponent,
    BlogNavigationComponent
  ],
  imports: [
    CommonModule,
    SectionsModule,
    FormsModule,
    ReactiveFormsModule,
    NgxPaginationModule,
    RouterModule.forChild(routes)
  ]
})
export class BlogModule { }
