<!DOCTYPE html>
<html lang="en">
  <head>
    <!--
      This is the page head - it contains info the browser uses to display the page
      You won't see what's in the head in the page
      Scroll down to the body element for the page content
    -->

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="https://glitch.com/favicon.ico" />

    <!-- 
      This is an HTML comment
      You can write text in a comment and the content won't be visible in the page
    -->

    <title>Hello World!</title>

    <!-- Meta tags for SEO and social sharing -->
    <link rel="canonical" href="https://glitch-hello-website.glitch.me/" />
    <meta
      name="description"
      content="A simple website, built with Glitch. Remix it to get your own."
    />
    <meta name="robots" content="index,follow" />
    <meta property="og:title" content="Hello World!" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://glitch-hello-website.glitch.me/" />
    <meta
      property="og:description"
      content="A simple website, built with Glitch. Remix it to get your own."
    />
    <meta
      property="og:image"
      content="https://cdn.glitch.com/605e2a51-d45f-4d87-a285-9410ad350515%2Fhello-website-social.png?v=1616712748147"
    />
    <meta name="twitter:card" content="summary" />

    <!-- Import the webpage's stylesheet -->
    <link rel="stylesheet" href="/style.css" />

    <!-- Import the webpage's javascript file -->
    <script src="/script.js" defer></script>
  </head>
  <body>
    <!--
      This is the body of the page
      Look at the elements and see how they appear in the rendered page on the right
      Each element is defined using tags, with < and > indicating where each one opens and closes
      There are elements for sections of the page, images, text, and more
      The elements include attributes referenced in the CSS for the page style
    -->

    <!-- The wrapper and content divs set margins and positioning -->
    <div class="wrapper">
      <div class="content" role="main">
        <!-- This is the start of content for our page -->
        <h1 class="title">Hello World!</h1>

        <img
          src="https://cdn.glitch.com/a9975ea6-8949-4bab-addb-8a95021dc2da%2Fillustration.svg?v=1618177344016"
          class="illustration"
          alt="Editor illustration"
          title="Click the image!"
        />
        <!-- Instructions on using this project -->
        <div class="instructions">
          <h2>
            Using this project
          </h2>
          <p>
            This is the Glitch <strong>Hello Website</strong> project. You can
            use it to build your own site. Check out README.md in the editor for
            more info and next steps you can take!
          </p>
          <!-- ADD BUTTON HERE -->
          <button>
    Click me!
          </button>
          
          <!-- Once you've added the button from the readme, click it in the page -->
          <!-- Check out the function in script.js to see how it works -->
        </div>
      </div>
    </div>
    <!-- The footer holds our remix button — you can use it for structure or cut it out ✂ -->
    <footer class="footer">
      <div class="links"></div>
      <a
        class="btn--remix"
        target="_top"
        href="https://glitch.com/edit/#!/remix/glitch-hello-website"
      >
        <img
          src="https://cdn.glitch.com/605e2a51-d45f-4d87-a285-9410ad350515%2FLogo_Color.svg?v=1618199565140"
          alt=""
        />
        Remix on Glitch
      </a>
    </footer>
  </body>
</html>