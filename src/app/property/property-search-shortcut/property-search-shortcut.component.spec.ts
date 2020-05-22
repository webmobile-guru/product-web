import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PropertySearchShortcutComponent } from './property-search-shortcut.component';

describe('PropertySearchShortcutComponent', () => {
  let component: PropertySearchShortcutComponent;
  let fixture: ComponentFixture<PropertySearchShortcutComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [PropertySearchShortcutComponent]
    }).compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PropertySearchShortcutComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
