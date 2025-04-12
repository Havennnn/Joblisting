# How to Save the Images

Below is a guide for saving each of the provided images with the correct filename:

## Image Mapping

1. **Interview/Document Signing Image** (first image with people at a desk reviewing documents)

    - Save as: `banner1.jpg`

2. **Resume Review Image** (person holding a resume with laptop in background)

    - Save as: `banner2.jpg`

3. **Meeting Discussion Image** (person gesturing during a discussion)

    - Save as: `meeting-discussion.jpg`

4. **Team Meeting Image** (group of people around a laptop in an office)
    - Save as: `team-meeting.jpg`

## Steps to Save Images

### For Windows:

1. Right-click on each image
2. Select "Save Image As..."
3. Navigate to the `public/images/seeder` directory in your project
4. Save with the proper filename as listed above

### For Mac:

1. Control-click or right-click on each image
2. Select "Save Image As..."
3. Navigate to the `public/images/seeder` directory in your project
4. Save with the proper filename as listed above

## After Saving

After saving all the images, you can run the seeders:

```
php artisan db:seed
```

Or to run specific seeders:

```
php artisan db:seed --class=FeaturedItemSeeder
php artisan db:seed --class=EventSeeder
php artisan db:seed --class=BlogSeeder
```
