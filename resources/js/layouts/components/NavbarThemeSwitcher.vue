<script setup>
const themes = [
  {
    name: 'light',
    icon: 'bx-sun',
  },
  {
    name: 'dark',
    icon: 'bx-moon',
  },
]

const changeTheme = async (theme) => {
  try {
    await axios.patch(`/api/change-theme/${theme}`);
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
  <ThemeSwitcher :themes="themes" @change-theme="changeTheme" />
</template>
