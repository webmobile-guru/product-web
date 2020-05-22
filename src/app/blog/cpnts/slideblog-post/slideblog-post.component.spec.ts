import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SlideblogPostComponent } from './slideblog-post.component';

describe('SlideblogPostComponent', () => {
  let component: SlideblogPostComponent;
  let fixture: ComponentFixture<SlideblogPostComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SlideblogPostComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SlideblogPostComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
