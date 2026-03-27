---
title: "Two Stories for Anybody"
description: "Two Stories for Anybody — a diptych of electronic literature from 2006 by Shawn Rider: soRandom and Pee in the Pool."
---

## About These Works

In 2006, I wrote two short pieces of electronic literature that played with ideas central to what we were then calling "Web 2.0" — user-generated content, tagging, randomness, participation, and the tension between authored narrative and collective noise. Both pieces were performed at live readings at SUNY University at Buffalo and Hallwalls Art Center in Buffalo, New York.

They were built as simple PHP/MySQL applications, designed to present themselves in plain text so any venue or publication could style them however they liked. They were never widely promoted — life got in the way — and the servers they lived on have long since gone dark. This archive restores them as static sites, preserving the original mechanics through client-side JavaScript.

---

## How They Work

### soRandom

*soRandom* is a randomized hypertext short fiction narrated by Julian, a bus driver in Buffalo. The story is divided into twelve segment slots across three pages, and each slot has multiple possible text blocks in a database. Every time you load a page, the system randomly selects one block per slot, assembling a unique version of the story.

Certain words in the text are linked as keywords — clicking one pulls you into a "tangent" view, showing randomly selected passages tagged with that keyword. The tangent system creates a web of associations running beneath the surface narrative: follow "bus" and you get a different constellation of fragments than if you follow "nurse" or "rain."

The structure is fixed (twelve slots, three pages) but the content is fluid. Some readings surface Julian's humor; others land on something darker. The framework holds the story together while randomness gives each reading its own texture. This is the essential idea of tagged, database-driven content that was so exciting in 2006 — the same engine that powered Flickr tags and del.icio.us bookmarks, turned toward narrative.

### Pee in the Pool

*Pee in the Pool* (PitP) takes a different approach. The base text is a fixed eight-chapter story about a fictional dot-com company called RADDSTURR and the academic who studies it. But the piece was designed as a live, participatory system: anyone could submit a comment, and those comments would be randomly inserted into the story text.

During a reading or performance, I'd tell the audience to visit the URL and type whatever they wanted. The story would fill up with noise — jokes, spam, non sequiturs, heckles, earnest contributions, actual Viagra ads. The more people participated, the harder the story became to read. This was the point. In 2006, one of the dominant anxieties about user-generated content was flooding — the idea that open participation would drown out signal with noise. Flickr comment sections, Wikipedia edit wars, forum spam: PitP turned that anxiety into a literary device.

The original system color-coded comments by age: bright yellow for fresh contributions, fading to pale as they aged out. Over time, if nobody new showed up, the story would gradually clean itself. After a reading, it might take a day or two for the chaos to subside.

This archive preserves 377 original audience comments from 2006 and simulates the ebb and flow of activity. By default, the number of visible comments follows a time-of-day cycle — busier in the evening (when readings would have happened) and quieter during the day. You can also use the manual control to dial the activity up or down yourself, from a clean pool to a full reading-night flood.

---

## Context

These pieces belong to an era when the read/write web felt genuinely new and genuinely uncertain. Tagging, folksonomy, user participation, remix — these weren't settled infrastructure yet; they were experiments, and it wasn't clear what would survive. The literary possibilities felt wide open. *soRandom* and *PitP* are small explorations of that moment, trying to find what happens when you hand narrative control — partially or fully — to databases, algorithms, and audiences.

---

## Technical Notes

The originals were PHP 4/5 applications backed by a MySQL database, hosted on 1&1 shared hosting. This archive is a static site built with [Hugo](https://gohugo.io/), with all data extracted from the original database and all interactive behavior reimplemented in client-side JavaScript. The source is available on [GitHub](https://github.com/shawnr/elit-archive).

---

<small>These works are licensed under <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)</a>.</small>
