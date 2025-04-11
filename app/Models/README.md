# Model Structure

This directory contains the domain models for the application, organized in a domain-driven structure.

## Directory Structure

-   `app/Models/BaseModel.php` - Base abstract class that all models should extend
-   `app/Models/Users/` - Models related to user management
    -   `User.php` - User authentication model
    -   `Employer.php` - Employer profile
    -   `ApplicantProfile.php` - Applicant profile
-   `app/Models/Jobs/` - Models related to job listings
    -   `JobPost.php` - Job postings
    -   `JobApplication.php` - Applications for jobs
    -   `SavedJob.php` - Saved/bookmarked jobs
-   `app/Models/Messaging/` - Models for the messaging system
    -   `Conversation.php` - Conversation threads
    -   `Message.php` - Individual messages
-   `app/Models/Content/` - Content models
    -   `Event.php` - Events
    -   `Blog.php` - Blog posts
    -   `FeaturedItem.php` - Featured content items

## Implementation Details

For backward compatibility, the original model namespaces (App\Models\User, etc.) are still available as aliases to the new namespaced versions. This is handled in the ModelServiceProvider.

## Best Practices

1. Always extend BaseModel instead of Eloquent's Model class
2. Keep relationship methods in the model that owns the relationship
3. Use type hints in method signatures and doc blocks
4. Use proper namespaces for imports
5. Add appropriate casts for data types
