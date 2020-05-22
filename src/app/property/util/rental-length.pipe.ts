import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
  name: 'rentalLength'
})

export class RentalLengthPipe implements PipeTransform {
  transform(value: any, ...args: any[]) {
    if (value === 'YEARLY') {
      return '/ year';
    } else if (value === 'MONTHLY') {
      return '/ month';
    } else if (value === 'WEEKLY') {
      return '/ week';
    } else {
      return '';
    }
  }
}
