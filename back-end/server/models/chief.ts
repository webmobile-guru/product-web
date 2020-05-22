import {
  ExtendedPersistedModel,
  ExtendedStaticPersistedModel
} from "../types-and-interfaces/ExtendedPersistedModel";
import { Action } from "./action";

/** Represents a Chief sector */
export interface Chief extends ExtendedPersistedModel {
  id: number;
  name: string;
  code: string;

  actions(): Action[];
}

/** Represents a Chief sector */
export interface ChiefModel extends ExtendedStaticPersistedModel {}

export default (/* Model: ChiefModel */): void => {};
