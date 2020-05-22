import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PropertyDetailComponent } from './property/property-detail/property-detail.component';
import { PropertySearchComponent } from './property/property-search/property-search.component';
import { HomeComponent } from './home/home.component';
import { AgentDetailComponent } from './agent/agent-detail/agent-detail.component';
import { PropertySearchShortcutComponent } from './property/property-search-shortcut/property-search-shortcut.component';
import { PageNotFoundComponent } from './components/page-not-found/page-not-found.component';
import { PropertyDetailShortcutComponent } from './property/property-detail-shortcut/property-detail-shortcut.component';

const routes: Routes = [
  { path: '', component: HomeComponent, pathMatch: 'full' },
  { path: 'en', redirectTo: '/', pathMatch: 'full'},
  { path: 'en/search', component: PropertySearchComponent, pathMatch: 'full' },
  { path: 'agent/:id', component: AgentDetailComponent, pathMatch: 'full' },
  { path: 'p/:id', component: PropertyDetailShortcutComponent, pathMatch: 'full'},
  {
    path: ':lang/:section/:typeLocation',
    component: PropertySearchShortcutComponent,
    pathMatch: 'full'
  },
  {
    path: ':lang/:section/:location/:typeLocation',
    component: PropertySearchShortcutComponent,
    pathMatch: 'full'
  },
  {
    path: ':lang/:section/:location/:locationSlug/:slug',
    component: PropertyDetailComponent,
    pathMatch: 'full'
  },
  { path: '**', component: PageNotFoundComponent, pathMatch: 'full' }
];

@NgModule({
  exports: [RouterModule],
  imports: [RouterModule.forRoot(routes, {
    scrollPositionRestoration: 'disabled',
    anchorScrolling: 'disabled',
    enableTracing: false
  })]
})
export class AppRoutingModule {}
