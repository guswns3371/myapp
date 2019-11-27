require('babel-register')({
    presets: [ 'env' ]
});

module.exports =require('./myindex');

// 이런식으로해야 export import 키워드가 먹는다
