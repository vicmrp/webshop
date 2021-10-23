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

// bad 
const getUserCredentials = (user) => {
  const name = user.name;
  const surname = user.name;
  const password = user.password;
  const email = user.email;
}

// god
const getUserCredentials = (user) => {
  const { name, surname, password, email } = user
}

// ----- 11:44 ----- //


// ----- 13:39 ----- //
// VARIABLE NAMING

const camelCase = '';

let thisIsARandomCamelCaseName;

// ----- 13:39 ----- //

// ----- 15:03 ----- //
// Meaningful names

// Bad - because what user data?
getUserData
getUserInfo

// good
getUserPosts;

// Favor descriptive over concise

// bad
findUser;

// Good
findUserByNameOrEmail;
setUserLoggedInTrue;

// use shorter version

getUserFromDatabase;

getUser;

// ----- 15:03 ----- //

// ----- 16:54----- //

// Use consistent verbs per concept

// Functions will usually create, read, update or delete something

// bad
getQuestiens;
returnUsers;
retrieveUsers;

// good
getQuestiens;
getUsers;


// ----- 16:54----- //


// ----- 18:20----- //

// Make booleans that read well in if-then statements

let Car = {};

// bad
sedan , sold, green, airbag
car.sedan; car.sold; car.green; car.airbag;

// good - makes it easier to see that it is a boolean value
isSedan, isSold, isGreen, hasAirbag
car.isSedan; car.isSold; car.isGreen; car.hasAirbag

// ----- 18:20----- //

// ----- 19.36 ----- //
// Use nouns for classNames

// Bad
class MakeCar = {
  // ...
}

// Good
class Car = {
  // ...
}


// ----- 20:40 ----- //

// Use PascalCase for classNames.

camelCase;
PascalCase;

// good
class Task = {}
// bad
class task = {}

// ----- 20:40 ----- //


// ----- 21:34 ----- //
// Capitalize constant values SNAKE UPPER CASE

// Use SNAKE UPPER CASE for constant variables
const SECONDS_IN_A_DAY = 86400; // 
const HOURS_IN_DAY = 24;
const USER_AGE = 30;

// bad - because it is not a constant value. It changes.
const USER = foundUser;
const TODAY = new Date();

// good
const user = foundUser;
const today = new Date();


// ----- 21:34 ----- //

// ----- 23:29 ----- //
// Avoid one-letter variable names

// bad
const d = () => new Date

// good 
const newDate = () => new Date

// one letter variables is okay inside loops
for (let i = 0; i < 10; i++) {
  const element = 10;
  
}

// ----- 23:29 ----- //