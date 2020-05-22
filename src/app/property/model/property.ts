import { Agent } from '../../agent/model/agent';

export class Property {
  _id: string;
  unitType: string;
  listingType: string;
  agent: Agent;
  agency: string;
  reference: string;
  trakheesi: string;
  furnishedType: string;
  completionStatus: string;
  sizeSQM: number;
  sizeSQFT: number;
  amenities: string;
  title: string;
  description: string;
  geoPoint: string;
  type: string;
  coordinates: string;
  bedrooms: number;
  bathrooms: number;
  price: number;
  photos: [
    {
      lastUpdated: Date;
      originalUrl: String;
      url: String;
    }
  ];
  location1: {
    name: String;
    slug: String;
  };
  location2: {
    name: String;
    slug: String;
  };
  location3: {
    name: String;
    slug: String;
  };
  location4: {
    name: String;
    slug: String;
  };
  premium: boolean;
  featured: boolean;
  url: string;
}
