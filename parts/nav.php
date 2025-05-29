<?php if(session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<nav class="main-nav">
    <a href="index.php" class="logo">Training<em> Studio</em></a>
    <ul class="nav">
        <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
        <li class="scroll-to-section"><a href="#features">Q&A</a></li>
        <li class="scroll-to-section"><a href="#our-classes">Classes</a></li>
        <li class="scroll-to-section"><a href="#schedule">Schedules</a></li>
        <li class="scroll-to-section"><a href="#contact-us">Contact</a></li>
        <li class="main-button">
            <a href="#" onclick="openModal('signupModal')">Sign Up</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li style="text-align: center; margin-top: 20px; list-style: none;">
                <span style="color: black; font-size: 14px;">
                    You logged in as <strong><?= htmlspecialchars($_SESSION['username']); ?></strong> 
                    (<?= htmlspecialchars($_SESSION['role']); ?>)
                </span>
                <form action="users_db/auth.php" method="POST" style="margin-top: 5px;">
                    <input type="hidden" name="action" value="logout" />
                    <button type="submit" class="btn btn-danger" style="font-size: 13px;">Log out</button>
                </form>
            </li>
        <?php endif; ?>
    </ul>
</nav>
