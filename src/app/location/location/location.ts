export class Location {
  name: string;
  slug: string;
  level: number;
  parents: string[];
  parent: Location;
  children: Location[];
  locationPath: string;
  isMulti: boolean;
  parentString: string;
}
