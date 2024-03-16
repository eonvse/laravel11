<div class="flex items-center">
  <a
    id="theme-switcher"
    class="block w-full whitespace-nowrap bg-transparent px-3 py-2 text-sm font-normal text-gray-700 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none active:text-zinc-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-gray-400 dark:text-gray-100 dark:hover:bg-gray-600 focus:dark:bg-gray-600"
    href="#"
    data-theme="light">
    <div class="pointer-events-none">
      <div
        class="inline-block text-center"
        data-theme-icon="light">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="inline-block h-6 w-6">
          <path
            d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
        </svg>
      </div>
    </div>
  </a>
  <a
    id="theme-switcher"
    class="block w-full whitespace-nowrap bg-transparent px-3 py-2 text-sm font-normal text-gray-700 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none active:text-zinc-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-gray-400 dark:text-gray-100 dark:hover:bg-gray-600 focus:dark:bg-gray-600"
    href="#"
    data-theme="dark"
    data-te-dropdown-item-ref>
    <div class="pointer-events-none">
      <div
        class="inline-block text-center"
        data-theme-icon="dark">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="inline-block h-6 w-6">
          <path
            fill-rule="evenodd"
            d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z"
            clip-rule="evenodd" />
        </svg>
      </div>
    </div>
  </a>
  <script type="text/javascript">
          
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            var hide = document.querySelector('#theme-switcher[data-theme="dark"]');
            var show = document.querySelector('#theme-switcher[data-theme="light"]');
            hide.style.display = 'none';
            show.style.display = 'block';
        } else {
            var hide = document.querySelector('#theme-switcher[data-theme="light"]');
            var show = document.querySelector('#theme-switcher[data-theme="dark"]');
            hide.style.display = 'none';
            show.style.display = 'block';
        };
  

        function setDarkTheme() {
            document.documentElement.classList.add("dark");
            localStorage.theme = "dark";            
            var hide = document.querySelector('#theme-switcher[data-theme="dark"]');
            var show = document.querySelector('#theme-switcher[data-theme="light"]');
            hide.style.display = 'none';
            show.style.display = 'block';

        };
        
        function setLightTheme() {
            document.documentElement.classList.remove("dark");
            localStorage.theme = "light";
            var hide = document.querySelector('#theme-switcher[data-theme="light"]');
            var show = document.querySelector('#theme-switcher[data-theme="dark"]');
            hide.style.display = 'none';
            show.style.display = 'block';
        };
        
        function onThemeSwitcherItemClick(event) {
          const theme = event.target.dataset.theme;
        
          if (theme === "system") {
            localStorage.removeItem("theme");
            setSystemTheme();
          } else if (theme === "dark") {
            setDarkTheme();
          } else {
            setLightTheme();
          }
        };
        
        const themeSwitcherItems = document.querySelectorAll("#theme-switcher");
        themeSwitcherItems.forEach((item) => {
          item.addEventListener("click", onThemeSwitcherItemClick);
        });
    </script>
</div>