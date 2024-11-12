enum ThemeEnum {
    light = "light",
    dark = "dark"
}

export default class Theme {
    public static theme: ThemeEnum = ThemeEnum.dark;
    public static themeSwitcher: HTMLButtonElement | null = document.querySelector("button.Portfolio-theme");

    public static init(): void {
        this.themeSwitcher?.addEventListener("click", (): void => {
            this.toggleTheme();
            this.toggleButton();
        });
    }

    public static toggleTheme(): void {
        document.documentElement.classList.toggle("isLight");

        if (this.theme === ThemeEnum.light) {
            this.theme = ThemeEnum.dark;
        } else {
            this.theme = ThemeEnum.light;
        }
    }

    public static toggleButton(): void {
        this.themeSwitcher?.classList.toggle("isLight");
    }
}