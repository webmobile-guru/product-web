import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './home.component';
import { SectionsModule } from '../_shared/sections/sections.module';
import { ServicesComponent } from './cpnts/services/services.component';
import { ViewTutorialComponent } from './cpnts/view-tutorial/view-tutorial.component';
import { SlideTextImageComponent } from './cpnts/slide-text-image/slide-text-image.component';
import { SubmitEmailComponent } from './cpnts/submit-email/submit-email.component';

const routes: Routes = [
    {
        path: '',
        component: HomeComponent
    },
];

@NgModule({
    declarations: [
        HomeComponent,
        ServicesComponent,
        ViewTutorialComponent,
        SlideTextImageComponent,
        SubmitEmailComponent,
    ],
    imports: [
        CommonModule,
        SectionsModule,
        RouterModule.forChild(routes),
    ]
})
export class HomeModule { }
