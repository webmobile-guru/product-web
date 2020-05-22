import { Component, Inject, Input, OnInit, PLATFORM_ID } from '@angular/core';
import { Agent } from '../model/agent';
import { ActivatedRoute, Router } from '@angular/router';
import { AgentService } from '../agent.service';
import { PropertyService } from '../../property/property.service';
import { Observable, Subscription } from 'rxjs';
import { Property } from '../../property/model/property';
import { SearchStateService } from '../../property/property-search/search-state.service';
import { isPlatformServer } from '@angular/common';

@Component({
  selector: 'app-agent-detail',
  templateUrl: './agent-detail.component.html',
  styleUrls: ['./agent-detail.component.css']
})
export class AgentDetailComponent implements OnInit {
  @Input() agent: Agent;
  subscription: Subscription;
  properties$: Observable<Property[]>;
  properties: Property[] = [];

  constructor(
    private route: ActivatedRoute,
    private agentService: AgentService,
    private propertyService: PropertyService,
    private router: Router,
    private searchStateService: SearchStateService,
    @Inject(PLATFORM_ID) private platformId
  ) {}

  ngOnInit() {
    this.getAgent();
    if (!isPlatformServer(this.platformId)) {
      // If not the server
      window.scroll(0, 0);
    }
  }

  getAgent(): void {
    const id = this.route.snapshot.paramMap.get('id');
    this.agentService.getAgent(id).subscribe((agent) => {
      this.agent = agent;
      this.subscription = this.propertyService.searchProperties({ agent: agent._id }, 'AGENT_PAGE').subscribe((properties) => {
        this.properties = properties['properties'];
        this.searchStateService.listCount.next(properties['count']);
        this.searchStateService.locationsProp.next(properties['locations']);
      });
    });
  }

  setSearchPropertyData(query) {
    this.router.navigateByUrl('en/search?' + query);
  }
}
