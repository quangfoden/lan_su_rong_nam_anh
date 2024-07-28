<template>
  <div :class="keyboardClass"></div>
</template>

<script>
import Keyboard from "simple-keyboard";
import "simple-keyboard/build/css/index.css";
import layout from "../jsonLanguage/chinese";


export default {
name: "SimpleKeyboard",
props: {
  keyboardClass: {
    default: "simple-keyboard",
    type: String
  },
  input: {
    type: String
  }
},
data: () => ({
  keyboard: null,
}),
mounted() {
  this.keyboard = new Keyboard({
    ...layout,
    onChange: this.onChange,
    onKeyPress: this.onKeyPress
  });
},
methods: {
  onChange(input) {
    this.$emit("onChange", input);
  },
  onKeyPress(button) {
    this.$emit("onKeyPress", button);
    if (button === "{shift}" || button === "{lock}") this.handleShift();
  },
  handleShift() {
    let currentLayout = this.keyboard.options.layoutName;
    let shiftToggle = currentLayout === "default" ? "shift" : "default";

    this.keyboard.setOptions({
      layoutName: shiftToggle
    });
  }
},
watch: {
  input(input) {
    this.keyboard.setInput(input);
  }
}
};

</script>

<style>
input {
width: 100%;
height: 100px;
padding: 20px;
font-size: 20px;
border: none;
box-sizing: border-box;
}

.simple-keyboard {
width: 100%;
}
</style>