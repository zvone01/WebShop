import { AbstractControl } from '@angular/forms';

export function ValidateDate(control: AbstractControl) {

  if (control.value.Date < Date.now()) {
    return { validDate: true };
  }
  return null;
}


export function ValidatePersonNum(control: AbstractControl) {

    if (control.value.PersonNum < 1) {
      return { validPersonNum: true };
    }
    return null;
  }