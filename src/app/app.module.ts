import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { PropertyDetailComponent } from './property/property-detail/property-detail.component';
import { PropertySearchComponent } from './property/property-search/property-search.component';
import { AppRoutingModule } from './app-routing.module';
import { HomeComponent } from './home/home.component';
import { PropertySearchFormComponent } from './property/property-search-form/property-search-form.component';
import { PropertySearchResultComponent } from './property/property-search-result/property-search-result.component';
import { AgentDetailComponent } from './agent/agent-detail/agent-detail.component';
import { NavsComponent } from './components/navs/navs.component';
import { PropertySearchShortcutComponent } from './property/property-search-shortcut/property-search-shortcut.component';
import { GoogleAnalyticsService } from './google-analytics.service';
import { FooterComponent } from './components/footer/footer.component';
import { CustomSearchHeaderComponent } from './property/custom-search-header/custom-search-header.component';
import { PageNotFoundComponent } from './components/page-not-found/page-not-found.component';
import { TimeAgoPipe } from 'time-ago-pipe';
import { AgmCoreModule } from '@agm/core';

import { environment } from '../environments/environment';
import {RentalLengthPipe} from './property/util/rental-length.pipe';
import { RetainScrollPolyfillModule } from './retain-scroll-polyfill/retain-scroll-polyfill.module';
import { PropertyDetailShortcutComponent } from './property/property-detail-shortcut/property-detail-shortcut.component';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    PropertySearchFormComponent,
    PropertyDetailComponent,
    PropertySearchComponent,
    PropertySearchResultComponent,
    AgentDetailComponent,
    NavsComponent,
    PropertySearchShortcutComponent,
    FooterComponent,
    CustomSearchHeaderComponent,
    PageNotFoundComponent,
    TimeAgoPipe,
    RentalLengthPipe,
    PropertyDetailShortcutComponent
  ],
  imports: [
    BrowserModule.withServerTransition({ appId: 'serverApp' }),
    RetainScrollPolyfillModule.forRoot({
      pollDuration: 3000,
      pollCadence: 30
    }),
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    AppRoutingModule,
    AgmCoreModule.forRoot({
      apiKey: environment.GOOGLE_MAP_KEY
    })
  ],
  providers: [GoogleAnalyticsService],
  bootstrap: [AppComponent]
})
export class AppModule {}
