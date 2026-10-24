import { defineStore } from "pinia";
import { ref } from "vue";

export const useSnackbarStore = defineStore("snackbar", () => {
  const show = ref(false);
  const message = ref("");
  const color = ref("success");
  const icon = ref("bx-check-circle");

  const triggerSnackbar = (msg, type = "success") => {
    show.value = true;
    message.value = msg;
    color.value = type;

    if (type === "success") {
      icon.value = "bx-check-circle";
    } else if (type === "error") {
      icon.value = "bx-x-circle";
    } else if (type === "warning") {
      icon.value = "bx-error";
    } else {
      icon.value = "bx-info-circle";
    }
  };

  return { show, message, color, icon, triggerSnackbar };
});
