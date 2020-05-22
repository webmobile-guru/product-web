import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SlideTextImageComponent } from './slide-text-image.component';

describe('SlideTextImageComponent', () => {
  let component: SlideTextImageComponent;
  let fixture: ComponentFixture<SlideTextImageComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SlideTextImageComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SlideTextImageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
