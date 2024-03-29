# Post Loop Block

This WordPress plugin generates a new custom block for the Gutenberg editor.  The purpose of the block is to allow a page editor the ability to display a post loop with previous and forward page navigation.  It also gives the ability to set how many posts are in the loop per page.

This was a learning project.  I haven't built a completely custom block yet, only toyed around and provided support for other blocks.  Was really cool diving into the Gute's API and doing some JS work I haven't dealt with in a while.

### ===== Dev Notes =====

#### PHP

**Static Utilities**

I chose to stick my functional classes into a Utility namespace and make them static for a couple of reason.

 - They don't really do anything more than provide some hooked or filtered functionality for the js and front end display.
 - I'm used to build server side heavy web apps with large scoping and architecture before writing code.  Typically I use containers and direct injection but that felt like overkill for this plugin.
 - I'm not using service providers and I hate instantiating a class when it's not needed.

--- 
 
#### JS

I chose to webpack the editor and block JS because its the core of the project.  I haven't written a JS project where I setup everything in a year or more, so this was good practice as well.

The front end JS should be refactored a bit, but I don't have the time.  It would be easier to read and extend if I used webpack and classes, I didn't from the start because I thought I'd only need about 1/3 of how much I ended up with.

I also didn't think about the fact there could be multiple post loop blocks on the same page until I was about halfway through.  OOPS! So there's a little funkiness in there to make that work.

---

#### CSS

I haven't done themeing in quite some time and when I do I typically use Post CSS or SASS.  I went with the bare minimum of styling needs here and just used a small amount of vanilla css.  Implementing PCSS with webpack definitely felt like too much for this project.

### ===== Build =====

To get this plugin operational, clone the repo to the /wp-content/plugins directory or download and copy it.

Run composer from root directory of plugin

`composer install`

Use the appropriate node/npm version

`nvm use`

Install required packages

`npm install`

That's it!

### ===== Testing =====

I didn't write any integration or unit tests for this, but to test as a user just simply make sure you activate the plugin.  The site for testing should have at least a half dozen or so blog posts so you can test paging.

Once plugin is active and there are some test posts, go create a new page and add a couple of the Post Loop Block blocks to it using Gutenberg.  Save the page, go view it, click back and next and such to flip through pages of posts.
