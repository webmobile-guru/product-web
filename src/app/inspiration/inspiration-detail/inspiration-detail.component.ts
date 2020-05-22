import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-inspiration-detail',
  templateUrl: './inspiration-detail.component.html',
  styleUrls: ['./inspiration-detail.component.scss']
})
export class InspirationDetailComponent implements OnInit {

  id: string;
  constructor(
    private activatedRoute: ActivatedRoute
  ) { }

  ngOnInit() {
    this.activatedRoute.params.subscribe(params => {
      this.id = params['id'];
      console.log('this is inspiration detail id: ', params['id']); // Print the parameter to the console. 
    });
    // or you can get id: this.route.snapshot.paramMap.get('id')
  }

}
