function test() {
  return returnPromise().then((value) => {
    console.log('1st then, inside test(): ' + value);
    return 'Hello';
  }).then((value) => {
    console.log('2nd then, inside test(): ' + value);
    return 'world';
  });
}

function returnPromise() {
  return new Promise(function(resolve, reject) {
    resolve('start of new Promise');
  });
}

test().then((value) => {
  console.log('3rd then, after calling test: ' + value);
});