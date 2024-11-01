//CategoryとUnitのIDで、1桁のものを0から表示するため
export function padNumber(number,length){
  return number.toString().padStart(length,'0');
}