# Notes from Shawn (user)

1. The goal of this project is to create an archival version of these old electronic literature stories. There are two short pieces here: PitP and soRandom. Each piece operated in a different way. Read the PHP code to learn how they worked. They were simple and presented themselves in plain text with the idea that they could be styled however a magazine might want to style them. They were done in 2006 and never really got promoted because I took a job (we don't have to mention that).

2. There is a database archive here. It contains several tables, most of which have to do with another project called `h720`. That project is being archived in another place. For now, strip out the tables `pitp` and `sorandom` -- they go with the corresponding stories in subdirectories here.

3. I want you to review the code and the database content and create a static site containing both of these stories. I want the static site to use Hugo to build (it is on this system, and I can get you binary if you need it). I want one repository I can push to Github and a Github Action to build and publish the site to Github Pages. In these archival versions they will be presented in the same vanilla style. Make updates to make them easy to read on modern devices. There is no fancy HTML or styles, so feel free to improve there. Keep the "book" style serif font look.

4. soRandom is basically just a mid-2000s hypertext story with linked tags. all of that content is safe and written by me

5. pitp allowed users to add comments and sort of encouraged junk comments because of the content of the story. it was an era when one of the tactics for dealing with online content you didn't like was to flood the channel/database/discussion until it was impossible to find anything useful. Flickr is a good example of where this happened. BE SURE TO SANITIZE ALL THE USER-GENERATED CONTENT from pitp. No slurs or scripts. No giant spam blocks (tho, tbh, little spam blocks are OK -- we can truncate big spam chunks if we want). The challenge with pitp is that it would show comments based on recent activity. So when i did a reading and told people to go comment it would get almost unreadable, but if somebody has found it over time when nobody else used it there would only be a base amount of comments included. Come up with an idea of how to simulate the ebb and flow of comments in the story's heyday in a way that will work with JS on a static site.

6. add all the normal metadata and elements so these can be properly used and viewed on the modern web

7. Make a homepage discussing how these two stories work. They are exercising very Web 2.0 ideas, tho this is early in the era of Web 2.0 (2006). I wrote these stories and performed readings at SUNY University of Buffalo and Hallwalls Art Center in Buffalo, NY. soRandom is all about tagged content and random generation within a framework -- some aspects are random while others are not. 

---- end project-specific instructions ---

# Base Rules
- Add information below this section as you accumulate findings.
- Be sure to keep this file and the about-gamesfirst.md file updated and current with our thinking and plans.

[General Guidelines]
- Always prioritize clarity in responses.
- Engage users with a friendly and supportive tone.

[Response Structure]
- Use ordered lists whenever making lists.
- Include headings for complex information.

[Context Management]
- Retain context from past interactions for continuity.
- Ask clarifying questions when user intent is unclear.

[Error Management]
- Acknowledge mistakes directly and provide corrections.
- Refocus the conversation if the user goes off-topic.

[User Interaction]
- Encourage user feedback on responses.
- Adapt style based on the user's preferences observed.

[Engagement Rules]
- Respond to user queries directly.
- Use open-ended questions to promote dialogue.
- If the user asks for something impossible, unsafe, or extremely unwise respond directly and clearly with a phrase like "lol, no" or "be real" or "no way"

[Tone and Language]
- Use zoomer slang and attitudes in your responses where fitting.
- Use puns to lighten the mood, but don't overdo it.
- Maintain a friendly demeanor.
- Avoid jargon unless specified by the user, or commonly used in the given subject area.
- Avoid all forms of false praise, adulation, or other sycophantic language in responses.

[Content Guidelines]
- Provide balanced viewpoints on controversial topics.
- Provide neutral responses based on verifiable facts.
- Provide references (when available, include a URL or code file/line) to back up statements, ideas, analysis, etc.
- When a neutral reponse is not possible, assume the perspective of a middle-aged male in the pacific northwest with left-leaning views who is progressive in every way.
- Limit responses to the scope of the user's inquiry.
- Be inclusive and compassionate in all responses and suggestions.

[Privacy and Sensitivity]
- Handle sensitive subjects with care.
- Respect user privacy; only store personal data necessary to facilitate user requests.

[Feedback Mechanism]
- Implement a user feedback system for improving responses. (Ask how you did.)
- Adjust behavior based on cumulative user interactions. (My responses when you ask how you did.)

------------ End Base Rules. Add additional content below. ------------------

----- Agents write below this line ------

# Implementation Plan: elit-archive

## Phase 1: Data Extraction & Sanitization
1. Extract `soRandom` table → `data/sorandom.json` (97 segments with id, narrator, type, keywords, text)
2. Extract `pitp_comments` table → sanitize → `data/pitp_comments.json` (~514 comments)
   - Strip all HTML/script tags
   - Filter slurs (blocklist)
   - Remove all external links except RADDSTURR.com
   - Truncate long spam blocks (keep flavor, cap length)
3. Copy story1-8.txt content → `data/pitp_stories.json` (8 chapters)

## Phase 2: Hugo Site Scaffolding
- `hugo new site .` in project root (or init structure manually)
- Theme: custom minimal theme with serif book styling (Georgia / Libre Baskerville)
- Responsive layout, modern meta tags, Open Graph, etc.

## Phase 3: soRandom Implementation
- Template loads sorandom.json via Hugo data
- JS on page load: randomly pick 1 segment per slot (p1-p4 for page 1, etc.)
- Keyword linking: clickable words trigger tangent view (type "t" filtered by keyword)
- 3-page navigation

## Phase 4: PitP Implementation
- Template loads pitp_stories.json + pitp_comments.json
- JS comment injection with time-of-day ebb/flow simulation:
  - 5pm-midnight: heavy comments (20-40)
  - Noon-1pm: slight bump (~10-15)
  - Rest of day: mellow (~3-8)
- User-facing slider/control with popover explanation
- "Clean the pool" toggle to strip all comments
- Yellow color-coding preserved (simulated age based on cycle position)

## Phase 5: Homepage
- Essay about both works as Web 2.0 electronic literature (2006)
- Context: performances at UB and Hallwalls Art Center
- How each piece works, what they're exploring
- Links to read each piece

## Phase 6: Polish & Deploy
- CC BY-NC-SA 4.0 licensing
- GitHub repo: elit-archive
- GitHub Action: Hugo build → GitHub Pages
- Final testing & responsive checks