<template>
  <nav></nav>
  <router-view />
</template>

<style>

html,
body,
#app {
  margin: 0;
  padding: 0;
}
body {
  min-height: 100vh;
  overflow-x: hidden;
  background: var(--gray);
}
:root {
  --blue: #2a2185;
  --white: #fff;
  --gray: #f5f5f5;
  --black1: #222;
  --black2: #999;
  --shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
  --transition: all 0.3s ease;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}


* {
  font-family: "Ubuntu", sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
