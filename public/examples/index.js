// https://www.youtube.com/watch?v=RMN_bkZ1KM0 - write clean code

// ----- 1:44 ----- // 
// Magic Numbers - don't make random numbers. Name them instead!

  // not like this
  for (let i = 0; i < 86400; i++) {
    // ...
  }

  // do like this  
  const SECONDS_IN_A_DAY = 86400; // variable is in upper-snake-case

  for (let i = 0; i < SECONDS_IN_A_DAY; i++) {
    // ...
  }
// ----- 1:44 ----- //




// ----- 2:53 ----- //
// Deep nesting
const exampleArray = [ [ [ 'value' ] ] ];
// bad 

// exampleArray.forEach((array1) => {
//   array1.forEach((array2) => {
//     array2.forEach((el) => {
//       console.log(el);
//     })
//   })
// })

// good
const retrieveFinalValue = (element) => {
  if(Array.isArray(element)) {
    return retrieveFinalValue(element[0])
  }

  return element;
}

console.log(retrieveFinalValue(exampleArray));


// ----- 2:53 ----- //




// ----- 6:36 ----- //
// Stop writing comments - Code must speak for itself!

// Avoid large functions

// bad
const addMultiplySubstract = (a, b, c) => {
  // addition
  const addition = a + b + c;
  // multiplication
  const multiplication = a * b * c;
  // substraction
  const subraction = a - b - c;

  // return a string (addition, multiplication, substraction)
  return `${addition} ${multiplication} ${subraction}`
}

// good 
const add = (a,b,c) => a + b + c;
const multiply = (a,b,c) => a * b * c;
const subtract = (a,b,c) => a - b - c;

// ----- 6:36 ----- //


// ----- 11:44 ----- //
// Code repetition
// ----- 11:44 ----- //